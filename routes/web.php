<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Order;

Route::get('/', fn() => view('welcome'))->name('home');
// Midtrans Callback
Route::post('/midtrans/callback', [PaymentController::class, 'callback']);
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard utama
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return ($user->role === 'admin')
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');
    })->name('dashboard');

    // ===== ADMIN PAGES
    Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\EnsureUserIsAdmin::class)->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Produk
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->except(['show']);
        Route::patch('/orders/{order}/warranty-response', [App\Http\Controllers\Admin\OrderController::class, 'respondWarranty'])->name('orders.warrantyResponse');
        // Pesanan
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Pelanggan
        Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{user}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
        Route::get('/customers/{user}/edit', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('customers.edit');
        Route::patch('/customers/{user}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{user}', [App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    // ===== CUSTOMER PAGES
    Route::get('/customer/dashboard', function () {
        $userId = Auth::id();

        $totalOrders    = \App\Models\Order::where('user_id', $userId)->count();
        $pendingOrders  = \App\Models\Order::where('user_id', $userId)->where('status', 'pending')->count();
        $confirmedOrders = \App\Models\Order::where('user_id', $userId)->where('status', 'confirmed')->count();

        return view('customers.dashboard', compact('totalOrders', 'pendingOrders', 'confirmedOrders'));
    })->name('customer.dashboard');
    // ----- PESANAN SAYA -----
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');

    // ----- MENU -----
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/nasi-box', function () {
            $products = \App\Models\Product::where('category_id', 1)->where('is_active', 1)->orderBy('price')->get();
            return view('customers.menu.nasi-box', compact('products'));
        })->name('nasi-box');

        Route::get('/prasmanan', function () {
            $products = \App\Models\Product::where('category_id', 2)->where('is_active', 1)->orderBy('price')->get();
            return view('customers.menu.prasmanan', compact('products'));
        })->name('prasmanan');

        Route::get('/nasi-tumpeng', function () {
            $products = \App\Models\Product::where('category_id', 3)->where('is_active', 1)->orderBy('price')->get();
            return view('customers.menu.nasi-tumpeng', compact('products'));
        })->name('nasi-tumpeng');
    });

    // ----- CART -----
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/',                   [App\Http\Controllers\CartController::class, 'index'])->name('index');
        Route::post('/',                  [App\Http\Controllers\CartController::class, 'store'])->name('store');
        Route::patch('/{cart}/increment', [App\Http\Controllers\CartController::class, 'increment'])->name('increment');
        Route::patch('/{cart}/decrement', [App\Http\Controllers\CartController::class, 'decrement'])->name('decrement');
        Route::delete('/{cart}',          [App\Http\Controllers\CartController::class, 'destroy'])->name('destroy');
    });

    // ----- ORDER (unified untuk semua tipe) -----
    Route::get('/order/create', function () {
        $items = \App\Models\Cart::with('product')
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->get();
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong, pilih menu dulu.');
        }
        return view('customers.order.create', compact('items'));
    })->name('order.create');

    Route::post('/order', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
    // ===== PAYMENT =====
    Route::get('/orders/{order}/rating', [App\Http\Controllers\OrderRatingController::class, 'show'])->name('order.rating');
    Route::post('/orders/{order}/rating', [App\Http\Controllers\OrderRatingController::class, 'store'])->name('order.rating.store');
    Route::get('/payment/success/{order}', function (Order $order) {
        return view('customers.payment-success', compact('order'));
    })->name('payment.success');
    Route::get('/payment/failed/{order}', function (Order $order) {
        return view('customers.payment-failed', compact('order'));
    })->name('payment.failed');

    Route::get('/payment/pending/{order}', function (Order $order) {
        return view('customers.payment-pending', compact('order'));
    })->name('payment.pending');

    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('/payment/retry/{order}', [PaymentController::class, 'retry'])->name('payment.retry');
    Route::post('/orders/{order}/warranty', [App\Http\Controllers\OrderController::class, 'submitWarranty'])->name('order.warranty');

    Route::get('/payment/{order}', function (Order $order) {
        return view('customers.payment', compact('order'));
    })->name('payment.show');

    // Profile Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
