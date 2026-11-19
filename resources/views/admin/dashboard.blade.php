<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xl font-bold">Selamat datang, {{ auth()->user()->name }} 👋</p>
                    <p class="text-sm opacity-60 mt-0.5">
                        {{ now()->translatedFormat('l, d F Y') }} · Catering Mama Alif
                    </p>
                </div>
                <span
                    class="text-xs font-semibold px-3 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">
                    ✓ Sistem aktif
                </span>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="{{ route('admin.customers.index') }}"
                    class="rounded-2xl bg-base-100 shadow-sm border border-base-200 p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-2 opacity-60 text-sm">
                        <span>👥</span>
                        Pelanggan
                    </div>
                    <p class="text-3xl font-extrabold">{{ $totalCustomers }}</p>
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="rounded-2xl bg-base-100 shadow-sm border border-base-200 p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-2 opacity-60 text-sm">
                        <span>📦</span>
                        Produk
                    </div>
                    <p class="text-3xl font-extrabold">{{ $totalProducts }}</p>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="rounded-2xl bg-base-100 shadow-sm border border-base-200 p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-2 opacity-60 text-sm">
                        <span>🛒</span>
                        Pesanan
                    </div>
                    <p class="text-3xl font-extrabold">{{ $totalOrders }}</p>
                    @if ($pendingOrders > 0)
                        <p class="text-xs text-amber-600 mt-1 font-semibold">{{ $pendingOrders }} pending</p>
                    @endif
                </a>

                <div class="rounded-2xl bg-base-100 shadow-sm border border-base-200 p-4">
                    <div class="flex items-center gap-2 mb-2 opacity-60 text-sm">
                        <span>💰</span>
                        Revenue
                    </div>
                    <p class="text-2xl font-extrabold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Pesanan Terbaru --}}
                <div class="rounded-2xl bg-base-100 shadow-sm border border-base-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs font-bold uppercase tracking-widest opacity-40">Pesanan Terbaru</p>
                        <a href="{{ route('admin.orders.index') }}" class="text-xs text-blue-500 hover:underline">Lihat
                            semua</a>
                    </div>
                    <div class="space-y-0">
                        @forelse ($recentOrders as $order)
                            @php
                                $statusStyle = match ($order->status) {
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'processing' => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'completed' => 'bg-green-50 text-green-700 border-green-200',
                                    'failed' => 'bg-red-50 text-red-700 border-red-200',
                                    'cancelled' => 'bg-gray-50 text-gray-700 border-gray-200',
                                    default => 'bg-gray-50 text-gray-700 border-gray-200',
                                };
                                $statusLabel = match ($order->status) {
                                    'pending' => 'Pending',
                                    'confirmed' => 'Dibayar',
                                    'processing' => 'Diproses',
                                    'completed' => 'Selesai',
                                    'failed' => 'Gagal',
                                    'cancelled' => 'Dibatalkan',
                                    default => ucfirst($order->status),
                                };
                                $initials = collect(explode(' ', $order->user->name ?? 'U'))
                                    ->map(fn($w) => strtoupper($w[0]))
                                    ->take(2)
                                    ->join('');
                            @endphp
                            <div class="flex items-center gap-3 py-3 border-b border-base-200 last:border-0 last:pb-0">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ $initials }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold truncate">{{ $order->user->name ?? '-' }}</p>
                                    <p class="text-xs opacity-50 font-mono">{{ $order->order_number }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-bold">Rp
                                        {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    <span
                                        class="text-xs font-semibold px-2 py-0.5 rounded-full border {{ $statusStyle }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="text-blue-400 hover:text-blue-600 flex-shrink-0">
                                    <span class="text-sm opacity-40">→</span>
                                </a>
                            </div>
                        @empty
                            <p class="text-sm opacity-50 text-center py-6">Belum ada pesanan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Kanan: Status + Menu Terlaris --}}
                <div class="space-y-5">

                    {{-- Status Pesanan --}}
                    <div class="rounded-2xl bg-base-100 shadow-sm border border-base-200 p-5">
                        <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Status Pesanan</p>
                        <div class="space-y-3">
                            @php
                                $statuses = [
                                    [
                                        'label' => 'Selesai',
                                        'key' => 'completed',
                                        'color' => 'bg-green-400',
                                        'count' => $statusCounts['completed'] ?? 0,
                                    ],
                                    [
                                        'label' => 'Diproses',
                                        'key' => 'processing',
                                        'color' => 'bg-purple-400',
                                        'count' => $statusCounts['processing'] ?? 0,
                                    ],
                                    [
                                        'label' => 'Dibayar',
                                        'key' => 'confirmed',
                                        'color' => 'bg-blue-400',
                                        'count' => $statusCounts['confirmed'] ?? 0,
                                    ],
                                    [
                                        'label' => 'Pending',
                                        'key' => 'pending',
                                        'color' => 'bg-amber-400',
                                        'count' => $statusCounts['pending'] ?? 0,
                                    ],
                                    [
                                        'label' => 'Dibatalkan',
                                        'key' => 'cancelled',
                                        'color' => 'bg-gray-300',
                                        'count' => $statusCounts['cancelled'] ?? 0,
                                    ],
                                ];
                                $maxCount = max(max(array_column($statuses, 'count')), 1);
                            @endphp
                            @foreach ($statuses as $s)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="opacity-70">{{ $s['label'] }}</span>
                                        <span class="font-semibold">{{ $s['count'] }}</span>
                                    </div>
                                    <div class="w-full bg-base-200 rounded-full h-1.5">
                                        <div class="{{ $s['color'] }} h-1.5 rounded-full transition-all"
                                            style="width: {{ $maxCount > 0 ? round(($s['count'] / $maxCount) * 100) : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Menu Terlaris --}}
                    <div class="rounded-2xl bg-base-100 shadow-sm border border-base-200 p-5">
                        <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-4">Menu Terlaris</p>
                        <div class="space-y-0">
                            @forelse ($topProducts as $i => $product)
                                <div class="flex items-center gap-3 py-2.5 border-b border-base-200 last:border-0">
                                    <span class="text-sm font-bold opacity-30 w-4">{{ $i + 1 }}</span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold truncate">{{ $product->name }}</p>
                                        <p class="text-xs opacity-50">{{ $product->category->name ?? '-' }}</p>
                                    </div>
                                    <span class="text-sm font-bold">{{ $product->order_items_count }} terjual</span>
                                </div>
                            @empty
                                <p class="text-sm opacity-50 text-center py-4">Belum ada data.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
