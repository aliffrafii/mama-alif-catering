<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Kelola Pesanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="alert bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl p-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-base-100 rounded-2xl shadow-sm border border-base-200 p-4 mb-4">
                <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">

                    <div class="w-full md:w-64">
                        <label class="block text-sm font-medium text-base-content mb-2">
                            Status Pesanan
                        </label>

                        <select name="status" onchange="this.form.submit()"
                            class="w-full rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-[#6B7B3B] focus:outline-none">
                            <option value="">Semua Status</option>
                            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                            <option value="confirmed" @selected(request('status') == 'confirmed')>Dibayar</option>
                            <option value="processing" @selected(request('status') == 'processing')>Diproses</option>
                            <option value="completed" @selected(request('status') == 'completed')>Selesai</option>
                            <option value="failed" @selected(request('status') == 'failed')>Gagal</option>
                            <option value="cancelled" @selected(request('status') == 'cancelled')>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="w-full md:w-40">
                        <label class="block text-sm font-medium text-base-content mb-2">
                            Tampilkan
                        </label>

                        <select name="per_page" onchange="this.form.submit()"
                            class="w-full rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-[#6B7B3B] focus:outline-none">
                            @foreach ([10, 25, 50, 100] as $size)
                                <option value="{{ $size }}" @selected(request('per_page', 10) == $size)>
                                    {{ $size }} data
                                </option>
                            @endforeach
                        </select>
                    </div>

                </form>
            </div>
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">
                    Menampilkan {{ $orders->firstItem() ?? 0 }}
                    -
                    {{ $orders->lastItem() ?? 0 }}
                    dari {{ $orders->total() }} pesanan
                </p>
            </div>
            <div class="rounded-2xl bg-base-100 shadow overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @php
                                $style = match ($order->status) {
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
                            @endphp
                            <tr>
                                <td class="font-mono text-xs">{{ $order->order_number }}</td>
                                <td>{{ $order->user->name ?? '-' }}</td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="text-xs font-semibold px-2 py-1 rounded-full border {{ $style }}">
                                            {{ $statusLabel }}
                                        </span>

                                        @if ($order->warranty_claimed_at)
                                            <span title="Ada keluhan pelanggan"
                                                class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full border bg-red-50 text-red-600 border-red-200">
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                                Keluhan
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-xs opacity-60">
                                    {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="text-blue-500 hover:underline text-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
