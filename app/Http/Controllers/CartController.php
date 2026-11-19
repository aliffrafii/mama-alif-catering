<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $addonPrices = ['bakso' => 5000, 'dimsum' => 6000, 'eskrim' => 4500];

        $items = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $items->sum(function ($item) use ($addonPrices) {
            $unitPrice = $item->product->price ?? 0;
            if ($item->product->category_id == 2) {
                foreach ($item->selected_menus['gubukan'] ?? [] as $g) {
                    $unitPrice += $addonPrices[$g] ?? 0;
                }
            }
            return $unitPrice * $item->quantity;
        });

        return view('customers.cart.index', compact('items', 'total', 'addonPrices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id_product',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $product  = Product::findOrFail($request->product_id);
        $quantity = max(1, (int) $request->input('quantity', 1));

        // Parse selected_menus dari JSON string hidden input
        // ⚠️ JANGAN json_encode lagi — model sudah pakai cast 'array'
        //    jadi assign array langsung, Eloquent yang encode ke DB
        $selectedMenus = null;
        if ($request->filled('selected_menus')) {
            $decoded = json_decode($request->selected_menus, true);
            if (is_array($decoded)) {
                // Tambahkan nama produk ke selected_menus supaya terbaca di order_items
                $decoded['nama_paket'] = $product->name;
                $selectedMenus = $decoded;
            }
        }

        // Logika duplikat:
        // - Tumpeng (cat 3) tanpa selected_menus → bisa di-increment
        // - Nasi Box (cat 1) → selalu item baru (tiap pilihan menu berbeda)
        // - Prasmanan (cat 2) → selalu item baru (gubukan bisa beda)
        $existing = null;
        if ($product->category_id == 3 && empty($selectedMenus)) {
            $existing = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id_product)
                ->whereNull('selected_menus')
                ->first();
        }

        if ($existing) {
            $existing->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id'        => Auth::id(),
                'product_id' => $product->id_product,
                'quantity'       => $quantity,
                'selected_menus' => $selectedMenus, // assign array, cast otomatis ke JSON
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Berhasil ditambahkan ke keranjang!');
    }

    public function increment(Cart $cart)
    {
        abort_if($cart->user_id !== Auth::id(), 403);
        $cart->increment('quantity');
        return redirect()->route('cart.index');
    }

    public function decrement(Cart $cart)
    {
        abort_if($cart->user_id !== Auth::id(), 403);
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }
        return redirect()->route('cart.index');
    }

    public function destroy(Cart $cart)
    {
        abort_if($cart->user_id !== Auth::id(), 403);
        $cart->delete();
        return redirect()->route('cart.index')
            ->with('success', 'Item dihapus dari keranjang.');
    }
}
