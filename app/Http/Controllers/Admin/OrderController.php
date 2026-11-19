<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->get('per_page', 10);

        $orders = $query
            ->paginate($perPage)
            ->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $allowedTransitions = [
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['completed', 'cancelled'],
        ];

        if (!isset($allowedTransitions[$order->status])) {
            return back()->with(
                'error',
                'Status ini tidak dapat diubah secara manual.'
            );
        }

        $request->validate([
            'status' => 'required',
        ]);

        if (!in_array($request->status, $allowedTransitions[$order->status])) {
            return back()->with(
                'error',
                'Perubahan status tidak valid.'
            );
        }

        $data = [
            'status' => $request->status,
        ];

        // Set completed_at otomatis begitu status berubah jadi completed,
        // ini yang jadi acuan mulai hitung mundur masa garansi.
        if ($request->status === 'completed') {
            $data['completed_at'] = now();
        }

        $order->update($data);

        return back()->with(
            'success',
            'Status pesanan berhasil diperbarui.'
        );
    }
    public function respondWarranty(Request $request, Order $order)
    {
        $request->validate([
            'warranty_status'   => 'required|in:diajukan,diproses,selesai',
            'warranty_response' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'warranty_status'       => $request->warranty_status,
            'warranty_response'     => $request->warranty_response,
            'warranty_responded_at' => now(),
        ]);

        return back()->with('success', 'Tanggapan keluhan berhasil disimpan.');
    }
}
