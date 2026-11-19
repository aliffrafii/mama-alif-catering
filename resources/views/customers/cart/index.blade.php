<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Keranjang Pesanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="alert bg-green-50 border border-green-200 text-green-800 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($items->isEmpty())
                <div class="rounded-2xl bg-base-100 shadow p-10 text-center space-y-3">
                    <p class="text-4xl">🛒</p>
                    <p class="font-bold text-base-content">Keranjang kamu masih kosong</p>
                    <p class="text-sm opacity-50">Pilih menu dulu yuk!</p>
                    <div class="flex flex-col sm:flex-row gap-2 justify-center mt-2">
                        <a href="{{ route('menu.nasi-box') }}"
                            class="btn btn-sm bg-sky-100 hover:bg-sky-200 text-sky-800 border-none rounded-xl font-semibold">
                            Nasi Box
                        </a>
                        <a href="{{ route('menu.prasmanan') }}"
                            class="btn btn-sm bg-emerald-100 hover:bg-emerald-200 text-emerald-800 border-none rounded-xl font-semibold">
                            Prasmanan
                        </a>
                        <a href="{{ route('menu.nasi-tumpeng') }}"
                            class="btn btn-sm bg-amber-100 hover:bg-amber-200 text-amber-800 border-none rounded-xl font-semibold">
                            Nasi Tumpeng
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($items as $item)
                        @php
                            $sm = $item->selected_menus ?? [];
                            $catId = $item->product->category_id;
                            $unitPrice = $item->product->price;

                            // Tambah harga addon gubukan untuk prasmanan
                            if ($catId == 2) {
                                foreach ($sm['gubukan'] ?? [] as $g) {
                                    $unitPrice += $addonPrices[$g] ?? 0;
                                }
                            }

                            $icons = [1 => '🍱', 2 => '🍛', 3 => '🎋'];
                            $satuan = [1 => 'box', 2 => 'porsi', 3 => 'paket'];
                            $icon = $icons[$catId] ?? '🍽️';
                            $unit = $satuan[$catId] ?? 'item';

                            // Label nama paket (dari selected_menus atau nama produk)
                            $namaPaket = $sm['nama_paket'] ?? $item->product->name;
                        @endphp

                        <div class="rounded-2xl bg-base-100 shadow p-4 space-y-3">

                            {{-- Baris atas: ikon + info + tombol hapus --}}
                            <div class="flex items-start gap-3">
                                <div class="text-3xl leading-none pt-0.5">{{ $icon }}</div>
                                <div class="flex-1 min-w-0 space-y-1">
                                    <p class="font-bold text-sm">{{ $namaPaket }}</p>
                                    <p class="text-xs opacity-50">
                                        Rp {{ number_format($unitPrice, 0, ',', '.') }} / {{ $unit }}
                                    </p>

                                    {{-- Detail pilihan menu --}}
                                    @if (!empty($sm))
                                        <div class="mt-1 space-y-0.5 text-xs opacity-60">

                                            @if (!empty($sm['menu_utama']))
                                                <p>🍽️ Menu utama:
                                                    <span
                                                        class="font-medium">{{ ucwords(str_replace('_', ' ', $sm['menu_utama'])) }}</span>
                                                </p>
                                            @endif

                                            @if (!empty($sm['isian']))
                                                <p>🥘 Isian:
                                                    <span class="font-medium">
                                                        {{ collect($sm['isian'])->map(fn($v) => ucwords(str_replace('_', ' ', $v)))->implode(', ') }}
                                                    </span>
                                                </p>
                                            @endif

                                            @if (!empty($sm['tambahan']))
                                                <p>➕ Tambahan:
                                                    <span class="font-medium">
                                                        {{ collect($sm['tambahan'])->map(fn($v) => ucwords(str_replace('_', ' ', $v)))->implode(', ') }}
                                                    </span>
                                                </p>
                                            @endif

                                            @if (!empty($sm['gubukan']))
                                                <p>🍜 Gubukan:
                                                    <span class="font-medium">
                                                        {{ collect($sm['gubukan'])->map(fn($v) => ucwords($v))->implode(', ') }}
                                                    </span>
                                                </p>
                                            @endif

                                        </div>
                                    @endif
                                </div>

                                {{-- Tombol hapus --}}
                                <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition"
                                        onclick="return confirm('Hapus item ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            {{-- Baris bawah: kontrol qty + subtotal --}}
                            <div class="flex items-center justify-between pt-1 border-t border-base-200">
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('cart.decrement', $item) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-full border border-base-300 flex items-center justify-center text-lg font-bold hover:bg-base-200 transition">−</button>
                                    </form>

                                    <span class="w-8 text-center font-bold text-sm">{{ $item->quantity }}</span>

                                    <form method="POST" action="{{ route('cart.increment', $item) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-full border border-base-300 flex items-center justify-center text-lg font-bold hover:bg-base-200 transition">+</button>
                                    </form>

                                    <span class="text-xs opacity-40 ml-1">{{ $unit }}</span>
                                </div>

                                <p class="font-bold text-sm">
                                    Rp {{ number_format($unitPrice * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan total --}}
                <div class="rounded-2xl bg-base-100 shadow p-5 space-y-2 text-sm">
                    <p class="font-bold text-sm mb-3">Ringkasan</p>
                    @foreach ($items as $item)
                        @php
                            $unitP = $item->product->price;
                            if ($item->product->category_id == 2) {
                                foreach ($item->selected_menus['gubukan'] ?? [] as $g) {
                                    $unitP += $addonPrices[$g] ?? 0;
                                }
                            }
                            $nm = $item->selected_menus['nama_paket'] ?? $item->product->name;
                        @endphp
                        <div class="flex justify-between opacity-60">
                            <span>{{ $nm }} × {{ $item->quantity }}</span>
                            <span>Rp {{ number_format($unitP * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between opacity-40 text-xs">
                        <span>Biaya pengiriman</span>
                        <span>Belum termasuk</span>
                    </div>
                    <div class="border-t border-base-200 pt-3 flex justify-between font-bold text-base">
                        <span>Estimasi Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="space-y-2">
                    <a href="{{ route('order.create') }}"
                        class="btn w-full bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-2xl">
                        Lanjut ke Pemesanan →
                    </a>
                    <div class="grid grid-cols-3 gap-2">
                        <a href="{{ route('menu.nasi-box') }}" class="btn btn-outline btn-sm rounded-xl">🍱 Box</a>
                        <a href="{{ route('menu.prasmanan') }}" class="btn btn-outline btn-sm rounded-xl">🍛
                            Prasmanan</a>
                        <a href="{{ route('menu.nasi-tumpeng') }}" class="btn btn-outline btn-sm rounded-xl">🎋
                            Tumpeng</a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
