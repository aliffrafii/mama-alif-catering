<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Menu Nasi Box</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div
                class="rounded-3xl bg-gradient-to-br from-sky-500 to-sky-700 shadow-xl p-6 sm:p-8 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-32 h-32 rounded-full bg-white/10"></div>
                <div class="absolute right-16 bottom-0 w-16 h-16 rounded-full bg-white/5"></div>
                <div class="relative flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 8l8-4 8 4M4 8v8l8 4m-8-12l8 4m0 8l8-4V8m-8 12V12" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-black text-white">Paket Nasi Box</h1>
                            <p class="text-sm text-white/70 mt-0.5">{{ $products->count() }} pilihan ukuran box tersedia
                            </p>
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
                                class="absolute -top-1 -right-1 bg-white text-sky-700 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount }}</span>
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

            <div class="alert bg-sky-50 border border-sky-200 text-sky-800 text-sm rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z" />
                </svg>
                <span>Pilih box, tentukan menu & jumlah, lalu masukkan ke keranjang. Bisa pesan beberapa jenis
                    sekaligus!</span>
            </div>

            @php
                $colors = [
                    [
                        'border' => 'border-sky-500',
                        'dot' => 'bg-sky-500',
                        'badge_bg' => '#E0F2FE',
                        'badge_text' => '#075985',
                        'btn' => 'bg-sky-500 hover:bg-sky-600',
                        'img_bg' => 'from-sky-50 to-sky-100',
                        'icon' => 'text-sky-400',
                    ],
                    [
                        'border' => 'border-rose-500',
                        'dot' => 'bg-rose-500',
                        'badge_bg' => '#FFE4E6',
                        'badge_text' => '#9F1239',
                        'btn' => 'bg-rose-500 hover:bg-rose-600',
                        'img_bg' => 'from-rose-50 to-rose-100',
                        'icon' => 'text-rose-400',
                    ],
                    [
                        'border' => 'border-violet-500',
                        'dot' => 'bg-violet-500',
                        'badge_bg' => '#EEEDFE',
                        'badge_text' => '#3C3489',
                        'btn' => 'bg-violet-500 hover:bg-violet-600',
                        'img_bg' => 'from-violet-50 to-violet-100',
                        'icon' => 'text-violet-400',
                    ],
                ];
                $menuUtamaOptions = [
                    ['value' => 'ayam_kremes', 'label' => 'Ayam Kremes', 'icon' => '🍗'],
                    ['value' => 'ayam_bakar', 'label' => 'Ayam Bakar', 'icon' => '🔥'],
                    ['value' => 'ayam_kecap', 'label' => 'Ayam Kecap', 'icon' => '🍯'],
                    ['value' => 'semur_daging', 'label' => 'Semur Daging', 'icon' => '🍖'],
                    ['value' => 'rendang', 'label' => 'Rendang', 'icon' => '🌶️'],
                    ['value' => 'teriyaki', 'label' => 'Teriyaki', 'icon' => '🍢'],
                ];
                $isianOptions = [
                    ['value' => 'sambal_goreng_kentang', 'label' => 'Sambal Goreng Kentang', 'icon' => '🥔'],
                    ['value' => 'capcay', 'label' => 'Capcay', 'icon' => '🥬'],
                    ['value' => 'telur_balado', 'label' => 'Telur Balado', 'icon' => '🍳'],
                    ['value' => 'tempe_tahu', 'label' => 'Tempe dan Tahu', 'icon' => '🧈'],
                    ['value' => 'tumis_buncis_baso', 'label' => 'Tumis Buncis Baso', 'icon' => '🫘'],
                    ['value' => 'bihun', 'label' => 'Bihun', 'icon' => '🍜'],
                ];
                $tambahanOptions = [
                    ['value' => 'kerupuk', 'label' => 'Kerupuk', 'icon' => '🍘'],
                    ['value' => 'buah', 'label' => 'Buah', 'icon' => '🍊'],
                    ['value' => 'sambal', 'label' => 'Sambal', 'icon' => '🌶️'],
                    ['value' => 'sendok_tisu', 'label' => 'Sendok & Tisu', 'icon' => '🧻'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($products as $i => $product)
                    @php
                        $c = $colors[$i % count($colors)];
                        $maxIsian = $product->menu_options['max_isian'] ?? 2;
                        $imgUrl = $product->image
                            ? (\Illuminate\Support\Str::startsWith($product->image, 'http')
                                ? $product->image
                                : asset('storage/' . $product->image))
                            : null;
                    @endphp
                    <div
                        class="card bg-base-100 shadow border-t-4 {{ $c['border'] }} hover:shadow-lg transition-shadow">
                        <div class="p-5 flex flex-col h-full space-y-3">

                            @if ($imgUrl)
                                <div class="w-full h-40 rounded-2xl overflow-hidden">
                                    <img src="{{ $imgUrl }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @else
                                <div
                                    class="w-full h-40 rounded-2xl bg-gradient-to-br {{ $c['img_bg'] }} flex items-center justify-center">
                                    <svg class="w-14 h-14 {{ $c['icon'] }}" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 8l8-4 8 4M4 8v8l8 4m-8-12l8 4m0 8l8-4V8m-8 12V12" />
                                    </svg>
                                </div>
                            @endif

                            <div>
                                <span class="badge badge-sm"
                                    style="background:{{ $c['badge_bg'] }};color:{{ $c['badge_text'] }};">{{ $product->name }}</span>
                                <p class="text-2xl font-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}
                                    <span class="text-sm font-normal opacity-60">/ box</span>
                                </p>
                                @if ($product->description)
                                    <p class="text-xs opacity-50 mt-0.5">{{ $product->description }}</p>
                                @endif
                            </div>

                            <div class="divider my-0"></div>
                            <ul class="space-y-1.5 text-sm grow">
                                <li class="flex items-start gap-2"><span
                                        class="mt-1.5 w-1.5 h-1.5 rounded-full {{ $c['dot'] }} flex-shrink-0"></span>Nasi
                                    putih</li>
                                <li class="flex items-start gap-2"><span
                                        class="mt-1.5 w-1.5 h-1.5 rounded-full {{ $c['dot'] }} flex-shrink-0"></span>1
                                    menu utama pilihan</li>
                                <li class="flex items-start gap-2"><span
                                        class="mt-1.5 w-1.5 h-1.5 rounded-full {{ $c['dot'] }} flex-shrink-0"></span>{{ $maxIsian }}
                                    isian pilihan</li>
                            </ul>

                            <div class="divider my-0"></div>
                            <button type="button"
                                onclick="openNasiBoxModal({{ $product->id_product }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $maxIsian }}, '{{ $imgUrl ?? '' }}')"
                                class="btn w-full {{ $c['btn'] }} text-white border-none gap-2">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-9H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Masukkan ke Keranjang
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="opacity-50 text-sm">Belum ada paket Nasi Box tersedia.</p>
                @endforelse
            </div>

            {{-- Keterangan --}}
            <div class="card bg-base-100 shadow">
                <div class="p-5 space-y-3">
                    <h2 class="text-base font-bold">Keterangan & Syarat Pemesanan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div class="flex items-start gap-3 bg-base-200 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 mt-0.5 text-[#6B7B3B] flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
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
                        <div class="flex items-start gap-3 bg-base-200 rounded-xl px-4 py-3 sm:col-span-2">
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

    <dialog id="modal-nasi-box" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box max-w-md space-y-4">

            <div id="modal-img-wrap" class="hidden w-full h-36 rounded-2xl overflow-hidden">
                <img id="modal-img" src="" alt="" class="w-full h-full object-cover">
            </div>
            <div id="modal-img-placeholder"
                class="w-full h-36 rounded-2xl bg-gradient-to-br from-sky-50 to-sky-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 8l8-4 8 4M4 8v8l8 4m-8-12l8 4m0 8l8-4V8m-8 12V12" />
                </svg>
            </div>

            <h3 class="font-bold text-lg" id="modal-title">Pilih Menu Box</h3>
            <p class="text-sm opacity-60" id="modal-subtitle"></p>

            <form method="POST" action="{{ route('cart.store') }}" id="form-nasi-box">
                @csrf
                <input type="hidden" name="product_id" id="modal-product-id">
                <input type="hidden" name="selected_menus" id="modal-selected-menus">

                <div class="space-y-1 mb-4">
                    <label class="text-sm font-semibold">Jumlah Box</label>
                    <input type="number" name="quantity" id="modal-qty" min="1" value="1"
                        class="input input-bordered w-full" required>
                </div>

                <div class="space-y-2 mb-3">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-sm" style="background:#FAEEDA;color:#854F0B;">Langkah 1</span>
                        <p class="font-bold text-sm">Pilih Menu Utama <span class="opacity-40 font-normal">(pilih
                                1)</span></p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($menuUtamaOptions as $opt)
                            <label
                                class="flex items-center gap-2 cursor-pointer rounded-xl border border-base-200 px-3 py-2 hover:bg-base-50 transition has-[:checked]:border-amber-400 has-[:checked]:bg-amber-50">
                                <input type="radio" name="_menu_utama" value="{{ $opt['value'] }}"
                                    class="radio radio-sm modal-menu-utama" required>
                                <span class="text-base">{{ $opt['icon'] }}</span>
                                <span class="text-xs font-medium">{{ $opt['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-2 mb-3 transition-opacity" id="modal-step-isian"
                    style="opacity:0.4;pointer-events:none;">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-sm" style="background:#E1F5EE;color:#0F6E56;">Langkah 2</span>
                        <p class="font-bold text-sm">Pilih Isian <span class="opacity-40 font-normal"
                                id="modal-isian-label"></span></p>
                    </div>
                    <p class="text-xs opacity-40" id="modal-isian-counter">0 / ? dipilih</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($isianOptions as $opt)
                            <label
                                class="flex items-center gap-2 cursor-pointer rounded-xl border border-base-200 px-3 py-2 hover:bg-base-50 transition has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50">
                                <input type="checkbox" name="_isian[]" value="{{ $opt['value'] }}"
                                    class="checkbox checkbox-sm modal-isian">
                                <span class="text-base">{{ $opt['icon'] }}</span>
                                <span class="text-xs font-medium">{{ $opt['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-2 mb-4 transition-opacity" id="modal-step-tambahan"
                    style="opacity:0.4;pointer-events:none;">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-sm" style="background:#EEEDFE;color:#3C3489;">Langkah 3</span>
                        <p class="font-bold text-sm">Tambahan <span class="opacity-40 font-normal">(opsional)</span>
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($tambahanOptions as $opt)
                            <label
                                class="flex items-center gap-2 cursor-pointer rounded-xl border border-base-200 px-3 py-2 hover:bg-base-50 transition has-[:checked]:border-violet-400 has-[:checked]:bg-violet-50">
                                <input type="checkbox" name="_tambahan[]" value="{{ $opt['value'] }}"
                                    class="checkbox checkbox-sm modal-tambahan">
                                <span class="text-base">{{ $opt['icon'] }}</span>
                                <span class="text-xs font-medium">{{ $opt['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div id="modal-buah-wrap" class="hidden">
                        <label class="text-xs font-semibold opacity-60">Pilihan Buah</label>
                        <select name="_buah_pilihan" class="select select-bordered select-sm w-full mt-1">
                            <option value="jeruk">Jeruk</option>
                            <option value="pisang">Pisang</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('modal-nasi-box').close()"
                        class="btn flex-1 btn-outline rounded-xl">Batal</button>
                    <button type="submit" id="modal-submit-btn"
                        class="btn flex-1 bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-xl" disabled>
                        Tambah ke Keranjang
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <script>
        let currentMaxIsian = 2;

        function openNasiBoxModal(productId, name, price, maxIsian, imgUrl) {
            currentMaxIsian = maxIsian;
            document.getElementById('modal-product-id').value = productId;
            document.getElementById('modal-title').textContent = name;
            document.getElementById('modal-subtitle').textContent = 'Rp ' + price.toLocaleString('id-ID') + ' / box';
            document.getElementById('modal-isian-label').textContent = '(pilih ' + maxIsian + ')';
            document.getElementById('modal-isian-counter').textContent = '0 / ' + maxIsian + ' dipilih';

            const imgWrap = document.getElementById('modal-img-wrap');
            const imgEl = document.getElementById('modal-img');
            const imgPlaceholder = document.getElementById('modal-img-placeholder');
            if (imgUrl) {
                imgEl.src = imgUrl;
                imgEl.alt = name;
                imgWrap.classList.remove('hidden');
                imgPlaceholder.classList.add('hidden');
            } else {
                imgWrap.classList.add('hidden');
                imgPlaceholder.classList.remove('hidden');
            }

            document.querySelectorAll('.modal-menu-utama, .modal-isian, .modal-tambahan').forEach(el => {
                el.checked = false;
                el.disabled = false;
            });
            document.getElementById('modal-step-isian').style.opacity = '0.4';
            document.getElementById('modal-step-isian').style.pointerEvents = 'none';
            document.getElementById('modal-step-tambahan').style.opacity = '0.4';
            document.getElementById('modal-step-tambahan').style.pointerEvents = 'none';
            document.getElementById('modal-submit-btn').disabled = true;
            document.getElementById('modal-qty').value = 1;
            document.getElementById('modal-nasi-box').showModal();
        }

        document.querySelectorAll('.modal-menu-utama').forEach(r => {
            r.addEventListener('change', function() {
                document.getElementById('modal-step-isian').style.opacity = '1';
                document.getElementById('modal-step-isian').style.pointerEvents = 'auto';
                updateModalIsian();
            });
        });

        function updateModalIsian() {
            const checked = document.querySelectorAll('.modal-isian:checked').length;
            document.getElementById('modal-isian-counter').textContent = checked + ' / ' + currentMaxIsian + ' dipilih';
            document.querySelectorAll('.modal-isian').forEach(c => {
                c.disabled = !c.checked && checked >= currentMaxIsian;
            });
            if (checked === currentMaxIsian) {
                document.getElementById('modal-step-tambahan').style.opacity = '1';
                document.getElementById('modal-step-tambahan').style.pointerEvents = 'auto';
            } else {
                document.getElementById('modal-step-tambahan').style.opacity = '0.4';
                document.getElementById('modal-step-tambahan').style.pointerEvents = 'none';
            }
            const menuPicked = document.querySelector('.modal-menu-utama:checked') !== null;
            document.getElementById('modal-submit-btn').disabled = !(menuPicked && checked === currentMaxIsian);
        }

        document.querySelectorAll('.modal-isian').forEach(c => c.addEventListener('change', updateModalIsian));

        document.querySelector('.modal-tambahan[value="buah"]').addEventListener('change', function() {
            document.getElementById('modal-buah-wrap').classList.toggle('hidden', !this.checked);
        });

        document.getElementById('form-nasi-box').addEventListener('submit', function() {
            const selectedMenus = {
                menu_utama: document.querySelector('.modal-menu-utama:checked')?.value ?? null,
                isian: [...document.querySelectorAll('.modal-isian:checked')].map(c => c.value),
                tambahan: [...document.querySelectorAll('.modal-tambahan:checked')].map(c => c.value),
            };
            const buahWrap = document.getElementById('modal-buah-wrap');
            if (!buahWrap.classList.contains('hidden')) {
                selectedMenus.buah_pilihan = document.querySelector('[name="_buah_pilihan"]').value;
            }
            document.getElementById('modal-selected-menus').value = JSON.stringify(selectedMenus);
        });
    </script>
</x-app-layout>
