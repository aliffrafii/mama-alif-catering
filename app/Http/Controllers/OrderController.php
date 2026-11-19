<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori'); // box | prasmanan | tumpeng | null (semua)

        $categoryMap = [
            'box'       => 1,
            'prasmanan' => 2,
            'tumpeng'   => 3,
        ];

        $orders = Order::where('user_id', Auth::id())
            ->when($kategori && isset($categoryMap[$kategori]), function ($query) use ($kategori, $categoryMap) {
                $query->whereHas('orderItems.product', function ($q) use ($kategori, $categoryMap) {
                    $q->where('category_id', $categoryMap[$kategori]);
                });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('customers.order.index', compact('orders', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_acara'    => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'tanggal_acara' => 'required|date|after:' . now()->addDays(2)->format('Y-m-d'),
            'kecamatan'     => 'required|string',
            'alamat'        => 'required|string',
            'catatan'       => 'nullable|string',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Keranjang kosong, silakan pilih menu terlebih dahulu.');
        }

        $addonPrices = ['bakso' => 5000, 'dimsum' => 6000, 'eskrim' => 4500];

        // Hitung subtotal produk
        $totalHarga = 0;
        foreach ($cartItems as $item) {
            $unitPrice = $item->product->price;
            if ($item->product->category_id == 2) {
                foreach ($item->selected_menus['gubukan'] ?? [] as $g) {
                    $unitPrice += $addonPrices[$g] ?? 0;
                }
            }
            $totalHarga += $unitPrice * $item->quantity;
        }

        // Ambil ongkir dari hidden input (sudah dihitung di frontend)
        $shippingCost = (int) $request->shipping_cost;

        // Ambil nama kecamatan saja (format value: "Nama Kecamatan|jarak")
        $kecamatanParts = explode('|', $request->kecamatan);
        $kecamatanNama  = $kecamatanParts[0];

        // Buat Order
        $order = Order::create([
            'user_id'          => Auth::id(),
            'order_number'     => 'ORD-' . time(),
            'status'           => 'pending',
            'total_price'      => $totalHarga + $shippingCost,
            'shipping_cost'    => $shippingCost,
            'notes'            => $request->filled('catatan') ? $request->catatan : null,
            'delivery_date'    => $request->tanggal_acara,
            'delivery_address' => $kecamatanNama . ' - ' . $request->alamat,
            'phone'            => $request->phone,
        ]);

        // Buat OrderItems
        foreach ($cartItems as $item) {
            $unitPrice = $item->product->price;
            if ($item->product->category_id == 2) {
                foreach ($item->selected_menus['gubukan'] ?? [] as $g) {
                    $unitPrice += $addonPrices[$g] ?? 0;
                }
            }

            $sm        = $item->selected_menus ?? [];
            $itemNotes = [];
            if (!empty($sm['menu_utama'])) {
                $itemNotes[] = 'Menu Utama: ' . ucwords(str_replace('_', ' ', $sm['menu_utama']));
            }
            if (!empty($sm['isian'])) {
                $itemNotes[] = 'Isian: ' . collect($sm['isian'])
                    ->map(fn($v) => ucwords(str_replace('_', ' ', $v)))->implode(', ');
            }
            if (!empty($sm['tambahan'])) {
                $itemNotes[] = 'Tambahan: ' . collect($sm['tambahan'])
                    ->map(fn($v) => ucwords(str_replace('_', ' ', $v)))->implode(', ');
            }
            if (!empty($sm['gubukan'])) {
                $itemNotes[] = 'Gubukan: ' . collect($sm['gubukan'])
                    ->map(fn($v) => ucwords($v))->implode(', ');
            }

            OrderItem::create([
                'order_id'       => $order->id_order,
                'product_id'     => $item->product_id,
                'quantity'       => $item->quantity,
                'price'          => $unitPrice * $item->quantity,
                'selected_menus' => $item->selected_menus,
                'notes'          => implode(' | ', $itemNotes),
            ]);
        }

        // Kosongkan cart
        Cart::where('user_id', Auth::id())->delete();

        // Generate Snap Token Midtrans
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $order->update([
            'snap_token'        => $snapToken,
            'midtrans_order_id' => $order->order_number,
        ]);

        return redirect()->route('payment.show', $order->id_order);
    }

    /**
     * Submit klaim garansi (komplain) untuk order yang sudah completed.
     */
    public function submitWarranty(Request $request, Order $order)
    {
        $request->validate([
            'warranty_note' => 'required|string|max:1000',
        ]);

        abort_unless($order->user_id === Auth::id(), 403);

        if (!$order->isWarrantyActive()) {
            return back()->with('error', 'Masa garansi sudah berakhir atau tidak tersedia untuk pesanan ini.');
        }

        $order->update([
            'warranty_note'       => $request->warranty_note,
            'warranty_claimed_at' => now(),
            'warranty_status'     => 'diajukan',
        ]);

        return back()->with('success', 'Keluhan garansi berhasil dikirim. Tim kami akan segera menindaklanjuti.');
    }
}
