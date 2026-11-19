{{-- resources/views/components/admin-layout.blade.php --}}
@props(['title' => 'Admin'])

@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <aside class="lg:col-span-3">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body p-4">
                        <ul class="menu rounded-box">
                            <li class="menu-title">Admin Panel</li>
                            <li><a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li><a class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                                    href="{{ route('admin.customers.index') }}">Customers</a></li>
                            <li><a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                                    href="{{ route('admin.products.index') }}">Products</a></li>
                            <li><a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                                    href="{{ route('admin.orders.index') }}">Orders</a></li>
                        </ul>
                    </div>
                </div>
            </aside>

            <section class="lg:col-span-9 space-y-6">
                <header>
                    <h1 class="text-2xl font-extrabold">{{ $title }}</h1>
                    <p class="text-sm opacity-70">Kelola operasional catering secara terpusat.</p>
                </header>

                {{ $slot }}
            </section>
        </div>
    </div>
@endsection
