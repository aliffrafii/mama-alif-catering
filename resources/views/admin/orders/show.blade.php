<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Detail Pesanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="alert bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl p-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Card Info Pesanan --}}
            <div class="rounded-2xl bg-base-100 shadow p-5 space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-lg">{{ $order->order_number }}</p>
                        <p class="text-xs opacity-50">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <p class="text-2xl font-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm border-t border-base-200 pt-3">
                    <div>
                        <p class="opacity-50 text-xs uppercase">Pelanggan</p>
                        <p class="font-semibold">{{ $order->user->name ?? '-' }}</p>
                        <p class="opacity-60 text-xs">{{ $order->user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="opacity-50 text-xs uppercase">No. Telepon</p>
                        <p class="font-semibold">{{ $order->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="opacity-50 text-xs uppercase">Tanggal Acara</p>
                        <p class="font-semibold">
                            {{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="opacity-50 text-xs uppercase">Pembayaran</p>
                        <p class="font-semibold">{{ $order->payment_type ?? 'Belum bayar' }}</p>
                    </div>
                </div>

                <div class="border-t border-base-200 pt-3">
                    <p class="opacity-50 text-xs uppercase mb-1">Alamat</p>
                    <p class="text-sm">{{ $order->delivery_address }}</p>
                </div>

                @if ($order->notes)
                    <div class="border-t border-base-200 pt-3">
                        <p class="opacity-50 text-xs uppercase mb-1">Detail Pesanan</p>
                        <p class="text-sm">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Card Item Pesanan --}}
            <div class="rounded-2xl bg-base-100 shadow p-5 space-y-3">
                <p class="font-bold text-sm">Item Pesanan</p>

                <div class="space-y-3">
                    @foreach ($order->orderItems as $item)
                        <div class="flex gap-3 border border-base-200 rounded-xl p-3">
                            {{-- Gambar produk --}}
                            @if ($item->product?->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                    class="w-14 h-14 rounded-lg object-cover flex-shrink-0" />
                            @else
                                <div
                                    class="w-14 h-14 rounded-lg bg-base-200 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl">🍽️</span>
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                {{-- Nama produk & harga --}}
                                <div class="flex justify-between items-start gap-2">
                                    <p class="font-semibold text-sm">
                                        {{ $item->product?->name ?? 'Produk dihapus' }}
                                    </p>
                                    <p class="text-sm font-bold text-primary whitespace-nowrap">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <p class="text-xs opacity-50">
                                    {{ $item->quantity }} x Rp
                                    {{ number_format($item->price / $item->quantity, 0, ',', '.') }}
                                </p>

                                {{-- Selected menus --}}
                                @if (!empty($item->selected_menus))
                                    <div class="mt-1.5 space-y-0.5">
                                        @foreach ($item->selected_menus as $groupKey => $choices)
                                            @if (!empty($choices))
                                                <p class="text-xs text-gray-500">
                                                    <span class="font-medium capitalize">
                                                        {{ ucwords(str_replace('_', ' ', $groupKey)) }}:
                                                    </span>
                                                    {{ is_array($choices)
                                                        ? implode(', ', array_map(fn($c) => ucwords(str_replace('_', ' ', $c)), $choices))
                                                        : ucwords(str_replace('_', ' ', $choices)) }}
                                                </p>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Notes per item --}}
                                @if ($item->notes)
                                    <p class="text-xs text-gray-400 mt-1 italic">📝 {{ $item->notes }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="border-t border-base-200 pt-3 flex justify-between text-sm font-bold">
                    <span>Total</span>
                    <span class="text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Card Keluhan Pelanggan (hanya tampil kalau ada klaim garansi masuk) --}}
            @if ($order->warranty_claimed_at)
                @php $wStatus = $order->warrantyStatusConfig(); @endphp
                <div class="rounded-2xl bg-red-50 border border-red-200 shadow-sm p-5 space-y-3">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <p class="font-bold text-sm text-red-700 flex items-center gap-1.5">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            Keluhan Pelanggan
                        </p>
                        <span
                            class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $wStatus['bg'] }} {{ $wStatus['text'] }} {{ $wStatus['border'] }}">
                            {{ $wStatus['label'] }}
                        </span>
                    </div>

                    <p class="text-xs text-red-600/70">
                        Dilaporkan {{ $order->warranty_claimed_at->translatedFormat('d F Y, H:i') }}
                    </p>

                    <p class="text-sm text-red-900 bg-white/60 rounded-xl p-3 italic">
                        "{{ $order->warranty_note }}"
                    </p>

                    @if ($order->warranty_response)
                        <div class="bg-white/60 rounded-xl p-3">
                            <p class="text-xs font-semibold text-red-700 mb-1">Tanggapan Admin</p>
                            <p class="text-sm text-red-900">{{ $order->warranty_response }}</p>
                            <p class="text-xs text-red-600/60 mt-1">
                                {{ $order->warranty_responded_at?->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                    @endif

                    {{-- Form update status & tanggapan --}}
                    <form method="POST" action="{{ route('admin.orders.warrantyResponse', $order) }}"
                        class="pt-2 space-y-2 border-t border-red-200">
                        @csrf @method('PATCH')
                        <div class="flex flex-col sm:flex-row gap-2">
                            <select name="warranty_status" class="select select-bordered select-sm flex-1 rounded-xl">
                                <option value="diajukan" @selected($order->warranty_status === 'diajukan')>Menunggu Ditinjau</option>
                                <option value="diproses" @selected($order->warranty_status === 'diproses')>Sedang Diproses</option>
                                <option value="selesai" @selected($order->warranty_status === 'selesai')>Selesai Ditangani</option>
                            </select>
                        </div>
                        <textarea name="warranty_response" rows="3"
                            placeholder="Tulis tanggapan untuk pelanggan, misalnya: kami sedang mengecek dengan tim dapur, atau permintaan maaf dan solusi yang diberikan..."
                            class="textarea textarea-bordered w-full rounded-xl text-sm">{{ old('warranty_response', $order->warranty_response) }}</textarea>
                        <button type="submit"
                            class="rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2 transition">
                            Simpan Tanggapan
                        </button>
                    </form>
                </div>
            @endif

            {{-- Card Update Status --}}
            <div class="rounded-2xl bg-base-100 shadow p-5 space-y-3">
                <p class="font-bold text-sm">Update Status</p>

                @php
                    $nextStatuses = [];

                    if ($order->status === 'confirmed') {
                        $nextStatuses = [
                            'processing' => 'Processing',
                            'cancelled' => 'Cancelled',
                        ];
                    } elseif ($order->status === 'processing') {
                        $nextStatuses = [
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ];
                    }
                @endphp

                @if (empty($nextStatuses))
                    <p class="text-sm">
                        Status saat ini:
                        <span class="font-bold">{{ ucfirst($order->status) }}</span>
                    </p>
                @else
                    <div class="mb-3">
                        <p class="text-sm">
                            Status saat ini:
                            <span class="font-bold">{{ ucfirst($order->status) }}</span>
                        </p>
                    </div>
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}"
                        class="flex flex-col sm:flex-row gap-3">
                        @csrf @method('PATCH')
                        <select name="status" class="select select-bordered select-sm flex-1">
                            @foreach ($nextStatuses as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="rounded-xl bg-gradient-to-r from-[#6B7B3B] to-[#7E8E48] px-6 py-2.5 text-sm font-bold text-white shadow hover:scale-[1.02] hover:shadow-lg transition">
                            ✓ Update Status
                        </button>
                    </form>
                @endif
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline w-full rounded-2xl">← Kembali ke Daftar
                Pesanan</a>
        </div>
    </div>
</x-app-layout>
