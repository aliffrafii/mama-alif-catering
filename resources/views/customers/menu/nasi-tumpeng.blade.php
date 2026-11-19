<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Menu Nasi Tumpeng</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div
                class="rounded-3xl bg-gradient-to-br from-amber-500 to-amber-700 shadow-xl p-6 sm:p-8 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-32 h-32 rounded-full bg-white/10"></div>
                <div class="absolute right-16 bottom-0 w-16 h-16 rounded-full bg-white/5"></div>
                <div class="relative flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3l7 18H5L12 3zM9 14h6M10 18h4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-black text-white">Paket Nasi Tumpeng</h1>
                            <p class="text-sm text-white/70 mt-0.5">{{ $products->count() }} pilihan paket tersedia</p>
                        </div>
                    </div>
                    @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                    <a href="{{ route('cart.index') }}"
                        class="relative w-12 h-12 rounded-2xl bg-white/15 hover:bg-white/25 transition flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-9H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-white text-amber-700 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="alert bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z" />
                </svg>
                <span>Pilih paket lalu klik <strong>Masukkan ke Keranjang</strong>. Kamu bisa memesan beberapa paket
                    sekaligus.</span>
            </div>

            @php
                $paketMeta = [
                    'paket-tumpeng-mini' => [
                        'border' => 'border-amber-400',
                        'btn' => 'bg-amber-400 hover:bg-amber-500',
                        'dot' => 'bg-amber-400',
                        'badge_bg' => '#FEF3C7',
                        'badge_text' => '#92400E',
                        'img_bg' => 'from-amber-50 to-amber-100',
                        'icon' => 'text-amber-400',
                        'fitur' => [
                            'Nasi kuning / nasi putih',
                            'Ayam goreng / ayam bakar',
                            'Perkedel kentang',
                            'Tempe & tahu goreng',
                            'Urap sayur',
                            'Lalapan & sambal',
                        ],
                    ],
                    'paket-tumpeng-medium' => [
                        'border' => 'border-emerald-500',
                        'btn' => 'bg-emerald-500 hover:bg-emerald-600',
                        'dot' => 'bg-emerald-500',
                        'badge_bg' => '#DCFCE7',
                        'badge_text' => '#166534',
                        'img_bg' => 'from-emerald-50 to-emerald-100',
                        'icon' => 'text-emerald-400',
                        'fitur' => [
                            'Nasi kuning / nasi putih',
                            'Ayam goreng + rendang',
                            'Perkedel kentang',
                            'Tempe & tahu goreng',
                            'Urap sayur + capcay',
                            'Lalapan, sambal & kerupuk',
                        ],
                    ],
                    'paket-tumpeng-premium' => [
                        'border' => 'border-violet-500',
                        'btn' => 'bg-violet-500 hover:bg-violet-600',
                        'dot' => 'bg-violet-500',
                        'badge_bg' => '#EDE9FE',
                        'badge_text' => '#5B21B6',
                        'img_bg' => 'from-violet-50 to-violet-100',
                        'icon' => 'text-violet-400',
                        'fitur' => [
                            'Nasi kuning / nasi putih',
                            'Ayam goreng + rendang + semur daging',
                            'Perkedel kentang',
                            'Tempe & tahu goreng',
                            'Urap sayur + capcay + bihun',
                            'Lalapan, sambal, kerupuk & buah',
                        ],
                    ],
                ];
                $defaultMeta = [
                    'border' => 'border-base-300',
                    'btn' => 'bg-base-300',
                    'dot' => 'bg-base-300',
                    'badge_bg' => '#F3F4F6',
                    'badge_text' => '#374151',
                    'img_bg' => 'from-base-200 to-base-300',
                    'icon' => 'text-base-content/30',
                    'fitur' => [],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($products as $product)
                    @php $meta = $paketMeta[$product->slug] ?? $defaultMeta; @endphp
                    <div
                        class="card bg-base-100 shadow border-t-4 {{ $meta['border'] }} hover:shadow-lg transition-shadow">
                        <div class="p-5 flex flex-col h-full space-y-3">

                            @if ($product->image)
                                <div class="w-full h-36 rounded-xl overflow-hidden">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @else
                                <div
                                    class="w-full h-36 rounded-xl bg-gradient-to-br {{ $meta['img_bg'] }} flex items-center justify-center">
                                    <svg class="w-12 h-12 {{ $meta['icon'] }}" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 3l7 18H5L12 3zM9 14h6M10 18h4" />
                                    </svg>
                                </div>
                            @endif

                            <div>
                                <span class="badge badge-sm"
                                    style="background:{{ $meta['badge_bg'] }};color:{{ $meta['badge_text'] }};">{{ $product->name }}</span>
                                <p class="text-2xl font-bold mt-2">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                    <span class="text-sm font-normal opacity-60">/ paket</span>
                                </p>
                                <p class="text-xs opacity-50 mt-0.5">{{ $product->description }}</p>
                            </div>

                            <div class="divider my-0"></div>
                            <p class="text-xs uppercase tracking-wide opacity-50 font-semibold">Isi Paket</p>
                            <ul class="space-y-1.5 text-sm grow">
                                @foreach ($meta['fitur'] as $f)
                                    <li class="flex items-start gap-2">
                                        <span
                                            class="mt-1.5 w-1.5 h-1.5 rounded-full {{ $meta['dot'] }} flex-shrink-0"></span>{{ $f }}
                                    </li>
                                @endforeach
                            </ul>

                            <div class="divider my-0"></div>
                            <button type="button"
                                onclick="openTumpengModal({{ $product->id_product }}, '{{ $product->name }}', {{ $product->price }})"
                                class="btn w-full {{ $meta['btn'] }} text-white border-none gap-2">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-9H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Masukkan ke Keranjang
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Keterangan --}}
            <div class="card bg-base-100 shadow">
                <div class="p-5 space-y-3">
                    <h2 class="text-base font-bold">Keterangan & Syarat Pemesanan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div class="flex items-start gap-3 bg-base-200 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 mt-0.5 text-[#6B7B3B] flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 18H5L12 3z" />
                            </svg>
                            <p class="text-sm opacity-70">Tumpeng disajikan <strong>beserta tampah & hiasan</strong>
                                tradisional.</p>
                        </div>
                        <div class="flex items-start gap-3 bg-base-200 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 mt-0.5 text-[#6B7B3B] flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" />
                            </svg>
                            <p class="text-sm opacity-70">Kapasitas per paket bersifat <strong>estimasi</strong>,
                                tergantung porsi makan.</p>
                        </div>
                        <div class="flex items-start gap-3 bg-base-200 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 mt-0.5 text-[#6B7B3B] flex-shrink-0" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm opacity-70">Pemesanan minimal <strong>3 hari sebelum acara</strong>.</p>
                        </div>
                        <div class="flex items-start gap-3 bg-base-200 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 mt-0.5 text-[#6B7B3B] flex-shrink-0" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13h13V6H3v7zm0 0l3 5h7l3-5m-13 0h13m4 0h1a1 1 0 001-1V9.5a1 1 0 00-.29-.71l-2.5-2.5A1 1 0 0018.5 6H16v7z" />
                            </svg>
                            <p class="text-sm opacity-70">Harga belum termasuk <strong>biaya pengiriman</strong>.</p>
                        </div>
                        <div class="flex items-start gap-3 bg-base-200 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 mt-0.5 text-[#6B7B3B] flex-shrink-0" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-9H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="text-sm opacity-70">Kamu bisa memesan <strong>lebih dari 1 paket</strong>
                                sekaligus lewat keranjang.</p>
                        </div>
                        <div class="flex items-start gap-3 bg-base-200 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 mt-0.5 text-[#6B7B3B] flex-shrink-0" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <p class="text-sm opacity-70">Info lebih lanjut hubungi <strong>085719595219</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-base-200 px-5 py-4 text-sm opacity-70 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pondok Ungu Permai Sektor V Blok M5 No. 20, Bahagia, Babelan, Bekasi Utara &nbsp;·&nbsp;
                    085719595219</span>
            </div>
        </div>
    </div>

    <dialog id="modal-tumpeng" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box max-w-sm space-y-4">
            <h3 class="font-bold text-lg" id="tumpeng-modal-title"></h3>
            <p class="text-sm opacity-60" id="tumpeng-modal-subtitle"></p>

            <form method="POST" action="{{ route('cart.store') }}" id="form-tumpeng">
                @csrf
                <input type="hidden" name="product_id" id="tumpeng-product-id">

                <div class="space-y-1 mb-4">
                    <label class="text-sm font-semibold">Jumlah Paket</label>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="changeQty(-1)"
                            class="w-10 h-10 rounded-full border border-base-300 flex items-center justify-center text-xl font-bold hover:bg-base-200 transition">−</button>
                        <input type="number" name="quantity" id="tumpeng-qty" min="1" value="1"
                            class="input input-bordered w-full text-center font-bold text-lg" required>
                        <button type="button" onclick="changeQty(1)"
                            class="w-10 h-10 rounded-full border border-base-300 flex items-center justify-center text-xl font-bold hover:bg-base-200 transition">+</button>
                    </div>
                </div>

                <div class="rounded-xl bg-base-200 px-4 py-3 text-sm mb-4">
                    <div class="flex justify-between">
                        <span class="opacity-60">Estimasi total</span>
                        <span class="font-bold" id="tumpeng-preview-total">Rp 0</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('modal-tumpeng').close()"
                        class="btn flex-1 btn-outline rounded-xl">Batal</button>
                    <button type="submit"
                        class="btn flex-1 bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-xl">
                        Tambah ke Keranjang
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <script>
        let tumpengBasePrice = 0;

        function openTumpengModal(productId, name, price) {
            tumpengBasePrice = price;
            document.getElementById('tumpeng-product-id').value = productId;
            document.getElementById('tumpeng-modal-title').textContent = name;
            document.getElementById('tumpeng-modal-subtitle').textContent = 'Rp ' + price.toLocaleString('id-ID') +
                ' / paket';
            document.getElementById('tumpeng-qty').value = 1;
            updateTumpengPreview();
            document.getElementById('modal-tumpeng').showModal();
        }

        function changeQty(delta) {
            const input = document.getElementById('tumpeng-qty');
            const newVal = Math.max(1, (parseInt(input.value) || 1) + delta);
            input.value = newVal;
            updateTumpengPreview();
        }

        function updateTumpengPreview() {
            const qty = parseInt(document.getElementById('tumpeng-qty').value) || 0;
            document.getElementById('tumpeng-preview-total').textContent = 'Rp ' + (tumpengBasePrice * qty).toLocaleString(
                'id-ID');
        }

        document.getElementById('tumpeng-qty').addEventListener('input', updateTumpengPreview);
    </script>
</x-app-layout>
