<div>
    @if ($isAdmin)
        {{-- ================= ADMIN VIEW ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card bg-base-100 shadow">
                <div class="card-body p-5">
                    <p class="text-xs uppercase opacity-60">Customers</p>
                    <p class="text-3xl font-extrabold">{{ $totalUsers }}</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow">
                <div class="card-body p-5">
                    <p class="text-xs uppercase opacity-60">Products</p>
                    <p class="text-3xl font-extrabold">{{ $totalProducts }}</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow">
                <div class="card-body p-5">
                    <p class="text-xs uppercase opacity-60">Orders</p>
                    <p class="text-3xl font-extrabold">{{ $totalOrders }}</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow">
                <div class="card-body p-5">
                    <p class="text-xs uppercase opacity-60">Revenue (Completed)</p>
                    <p class="text-3xl font-extrabold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="font-bold text-lg">Recent Orders</h3>
                    <div class="divider my-2"></div>

                    @if (count($recentOrders) === 0)
                        <p class="opacity-70">Belum ada order.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $o)
                                        <tr>
                                            <td>#{{ $o['id'] }}</td>
                                            <td>
                                                <div class="font-semibold">{{ $o['user']['name'] ?? '-' }}</div>
                                                <div class="text-xs opacity-60">{{ $o['user']['email'] ?? '' }}</div>
                                            </td>
                                            <td>
                                                <span class="badge badge-outline">{{ $o['status'] }}</span>
                                            </td>
                                            <td>Rp {{ number_format((int) $o['total_price'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="font-bold text-lg">Top Products</h3>
                    <div class="divider my-2"></div>

                    @if (count($topProducts) === 0)
                        <p class="opacity-70">Belum ada data.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach ($topProducts as $p)
                                <li class="flex items-center justify-between">
                                    <div>
                                        <div class="font-semibold">{{ $p['name'] }}</div>
                                        <div class="text-xs opacity-60">
                                            Sold count: {{ $p['order_items_count'] }}
                                        </div>
                                    </div>
                                    <div class="text-sm font-bold">
                                        @if (!is_null($p['price']))
                                            Rp {{ number_format((int) $p['price'], 0, ',', '.') }}
                                        @else
                                            —
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @else
        {{-- ================= CUSTOMER VIEW ================= --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-bold">Pilih Menu Catering</h3>
                <p class="text-sm opacity-70">Pilih kategori: Nasi Box, Prasmanan, atau Nasi Tumpeng.</p>
            </div>

            <div class="flex items-center gap-2">
                <div class="badge badge-outline">Cart: {{ $cartCount }}</div>
            </div>
        </div>

        <div class="tabs tabs-boxed mt-4 bg-base-200 inline-flex">
            <a class="tab {{ $activeMenu === 'nasi-box' ? 'tab-active' : '' }}"
                wire:click.prevent="setMenu('nasi-box')">
                Nasi Box
            </a>
            <a class="tab {{ $activeMenu === 'prasmanan' ? 'tab-active' : '' }}"
                wire:click.prevent="setMenu('prasmanan')">
                Prasmanan
            </a>
            <a class="tab {{ $activeMenu === 'tumpeng' ? 'tab-active' : '' }}" wire:click.prevent="setMenu('tumpeng')">
                Nasi Tumpeng
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            @forelse ($products as $p)
                <div class="card bg-base-100 shadow hover:shadow-lg transition">
                    <div class="card-body">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h4 class="font-extrabold text-lg">{{ $p['name'] }}</h4>
                                <p class="text-xs opacity-60">{{ $p['category']['name'] ?? '' }}</p>
                            </div>
                            <span class="badge badge-primary badge-outline">
                                Rp {{ number_format((int) ($p['price'] ?? 0), 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <button class="btn btn-sm btn-primary btn-block">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="alert">
                        <span>Belum ada produk aktif untuk kategori ini. Pastikan kategori & produk sudah dibuat.</span>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="card bg-base-100 shadow mt-6">
            <div class="card-body">
                <h3 class="font-bold text-lg">Pesanan Saya (Terakhir)</h3>
                <div class="divider my-2"></div>

                @if (count($myOrders) === 0)
                    <p class="opacity-70">Anda belum punya pesanan.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($myOrders as $o)
                                    <tr>
                                        <td>#{{ $o['id'] }}</td>
                                        <td><span class="badge badge-outline">{{ $o['status'] }}</span></td>
                                        <td>Rp {{ number_format((int) $o['total_price'], 0, ',', '.') }}</td>
                                        <td class="text-sm opacity-70">{{ $o['created_at'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
