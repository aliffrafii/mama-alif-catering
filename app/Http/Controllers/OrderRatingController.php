<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderRatingController extends Controller
{
    public function show(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        return view('customers.order.rating', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        $order->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('orders.index')->with('success', 'Terima kasih atas rating Anda!');
    }
}
