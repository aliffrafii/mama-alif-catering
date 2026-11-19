<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TumpengOrderController extends Controller
{
    /**
     * Tampilkan form order tumpeng (data diambil dari cart).
     */
    public function create()
    {
        $hasItems = Cart::where('user_id', Auth::id())->exists();

        if (!$hasItems) {
            return redirect()->route('menu.nasi-tumpeng')
                ->with('error', 'Keranjang masih kosong. Pilih paket tumpeng terlebih dahulu.');
        }

        return view('customers.order.create-tumpeng');
    }

    /**
     * Simpan order dari cart ke tabel orders, lalu kosongkan cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_acara'    => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'tanggal_acara' => 'required|date|after:' . now()->addDays(2)->format('Y-m-d'),
            'alamat'        => 'required|string',
            'catatan'       => 'nullable|string',
        ]);

        $items = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($items->isEmpty()) {
            return redirect()->route('menu.nasi-tumpeng')
                ->with('error', 'Keranjang kosong. Tidak bisa membuat pesanan.');
        }

        $total = $items->sum(fn($i) => ($i->product->price ?? 0) * $i->quantity);

        $menuDetail = $items
            ->map(fn($i) => ($i->product->name ?? '?') . ' × ' . $i->quantity)
            ->implode(', ');

        $order = DB::transaction(function () use ($request, $total, $menuDetail) {
            $order = Order::create([
                'user_id'           => Auth::id(),
                'order_number'      => 'ORD-' . time(),
                'status'            => 'pending',
                'total_price'       => $total,
                'phone'             => $request->phone,
                'delivery_date'     => $request->tanggal_acara,
                'delivery_address'  => $request->alamat,
                'notes'             => ($request->catatan ? $request->catatan . ' | ' : '') . 'Acara: ' . $request->nama_acara . ' | ' . $menuDetail,
            ]);

            Cart::where('user_id', Auth::id())->delete();

            return $order;
        });

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

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
            'snap_token'         => $snapToken,
            'midtrans_order_id'  => $order->order_number,
        ]);

        return redirect()->route('payment.show', $order->id);
    }
}
