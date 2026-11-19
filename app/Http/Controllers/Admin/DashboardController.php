<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();
        $totalProducts  = \App\Models\Product::count();
        $totalOrders    = \App\Models\Order::count();
        $totalRevenue   = \App\Models\Order::where('status', 'completed')->sum('total_price');
        $pendingOrders  = \App\Models\Order::where('status', 'pending')->count();

        $recentOrders = \App\Models\Order::with('user')
            ->latest()->take(5)->get();

        $statusCounts = \App\Models\Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $topProducts = \App\Models\Product::withCount('orderItems')
            ->with('category')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'recentOrders',
            'statusCounts',
            'topProducts'
        ));
    }
}
