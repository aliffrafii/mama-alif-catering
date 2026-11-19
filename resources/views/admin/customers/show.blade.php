<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.index') }}" class="opacity-40 hover:opacity-100 transition">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M5 12l7-7M5 12l7 7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-base-content">Detail Pelanggan</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            {{-- Info Pelanggan --}}
            <div class="rounded-2xl bg-base-100 shadow p-5 flex items-center justify-between">
                <div>
                    <p class="font-bold text-lg">{{ $user->name }}</p>
                    <p class="text-sm opacity-60">{{ $user->email }}</p>
                </div>
                <a href="{{ route('admin.customers.edit', $user) }}"
                    class="rounded-xl bg-gradient-to-r from-[#6B7B3B] to-[#7E8E48] px-5 py-2 text-sm font-bold text-white shadow hover:scale-[1.02] transition">
                    Edit
                </a>
            </div>

            {{-- Riwayat Pesanan --}}
            <p class="font-bold text-sm opacity-70">Riwayat Pesanan</p>

            @if ($orders->isEmpty())
                <div class="rounded-2xl bg-base-100 shadow p-8 text-center text-sm opacity-50">
                    Belum ada pesanan dari pelanggan ini.
                </div>
            @else
                <div class="rounded-2xl bg-base-100 shadow overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="font-mono text-xs">{{ $order->order_number }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
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
                                        <span
                                            class="text-xs font-semibold px-2 py-1 rounded-full border {{ $style }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="text-xs opacity-60">
                                        {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="text-blue-500 hover:underline text-sm">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline w-full rounded-2xl">← Kembali ke
                Daftar Pelanggan</a>
        </div>
    </div>
</x-app-layout>
