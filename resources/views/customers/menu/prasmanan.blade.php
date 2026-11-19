<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Menu Prasmanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div
                class="rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-700 shadow-xl p-6 sm:p-8 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-32 h-32 rounded-full bg-white/10"></div>
                <div class="absolute right-16 bottom-0 w-16 h-16 rounded-full bg-white/5"></div>
                <div class="relative flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 12h16M4 12a8 8 0 0016 0M4 12a2 2 0 012-2h12a2 2 0 012 2M9 6a3 3 0 016 0" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-black text-white">Paket Prasmanan</h1>
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
                                class="absolute -top-1 -right-1 bg-white text-emerald-700 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount }}</span>
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

            <div class="alert bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z" />
                </svg>
                <span>Minimum pemesanan <strong>50 porsi</strong>. Add-on gubukan dihitung per porsi.</span>
            </div>

            @php
                $colors = [
                    [
                        'border' => 'border-orange-500',
                        'dot' => 'bg-orange-500',
                        'badge_bg' => '#FAECE7',
                        'badge_text' => '#993C1D',
                        'btn' => 'bg-orange-500 hover:bg-orange-600',
                        'img_bg' => 'from-orange-50 to-orange-100',
                        'icon' => 'text-orange-400',
                    ],
                    [
                        'border' => 'border-amber-500',
                        'dot' => 'bg-amber-500',
                        'badge_bg' => '#FAEEDA',
                        'badge_text' => '#854F0B',
                        'btn' => 'bg-amber-500 hover:bg-amber-600',
                        'img_bg' => 'from-amber-50 to-amber-100',
                        'icon' => 'text-amber-400',
                    ],
                    [
                        'border' => 'border-emerald-500',
                        'dot' => 'bg-emerald-500',
                        'badge_bg' => '#E1F5EE',
                        'badge_text' => '#0F6E56',
                        'btn' => 'bg-emerald-500 hover:bg-emerald-600',
                        'img_bg' => 'from-emerald-50 to-emerald-100',
                        'icon' => 'text-emerald-400',
                    ],
                ];
                $addonsGubukan = [
                    [
                        'value' => 'bakso',
                        'label' => 'Bakso',
                        'icon' => '🍜',
                        'harga' => 5000,
                        'desc' => 'Rp 5.000 / porsi',
                    ],
                    [
                        'value' => 'dimsum',
                        'label' => 'Dimsum',
                        'icon' => '🥟',
                        'harga' => 6000,
                        'desc' => 'Rp 6.000 / porsi',
                    ],
                    [
                        'value' => 'eskrim',
                        'label' => 'Es Krim',
                        'icon' => '🍦',
                        'harga' => 4500,
                        'desc' => 'Rp 4.500 / porsi',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse ($products as $i => $product)
                    @php
                        $c = $colors[$i % count($colors)];
                        $items = $product->menu_options['items'] ?? [];
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
                                            d="M4 12h16M4 12a8 8 0 0016 0M4 12a2 2 0 012-2h12a2 2 0 012 2M9 6a3 3 0 016 0" />
                                    </svg>
                                </div>
                            @endif

                            <div>
                                <span class="badge badge-sm"
                                    style="background:{{ $c['badge_bg'] }};color:{{ $c['badge_text'] }};">{{ $product->name }}</span>
                                <p class="text-2xl font-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}
                                    <span class="text-sm font-normal opacity-60">/ porsi</span>
                                </p>
                                <p class="text-xs opacity-50 mt-0.5">Min. 50 porsi · Est. Rp
                                    {{ number_format($product->price * 50, 0, ',', '.') }}</p>
                            </div>

                            <div class="divider my-0"></div>
                            <p class="text-xs uppercase tracking-wide opacity-50 font-semibold">Menu</p>
                            <ul class="space-y-1.5 text-sm grow">
                                @forelse ($items as $item)
                                    <li class="flex items-start gap-2">
                                        <span
                                            class="mt-1.5 w-1.5 h-1.5 rounded-full {{ $c['dot'] }} flex-shrink-0"></span>{{ $item }}
                                    </li>
                                @empty
                                    <li class="opacity-40 text-xs italic">Belum ada daftar menu.</li>
                                @endforelse
                            </ul>

                            <div class="divider my-0"></div>
                            <button type="button"
                                onclick="openPrasmananModal({{ $product->id_product }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $imgUrl ?? '' }}')"
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
                    <p class="opacity-50 text-sm col-span-3">Belum ada paket Prasmanan tersedia.</p>
                @endforelse
            </div>

            {{-- Gubukan info --}}
            <div class="card bg-base-100 shadow border-l-4 border-violet-500">
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-bold">Add-on Gubukan</h2>
                        <span class="badge badge-sm" style="background:#EEEDFE;color:#3C3489;">per porsi ·
                            opsional</span>
                    </div>
                    <p class="text-xs opacity-50">Bisa dipilih saat memasukkan ke keranjang.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach ($addonsGubukan as $addon)
                            <div
                                class="flex items-center gap-3 bg-violet-50 border border-violet-200 rounded-xl px-4 py-3">
                                <span class="text-2xl">{{ $addon['icon'] }}</span>
                                <div>
                                    <p class="text-sm font-semibold text-violet-900">{{ $addon['label'] }}</p>
                                    <p class="text-xs text-violet-600">{{ $addon['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
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

    <dialog id="modal-prasmanan" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box max-w-md space-y-4">

            <div id="prasmanan-modal-img-wrap" class="hidden w-full h-36 rounded-2xl overflow-hidden">
                <img id="prasmanan-modal-img" src="" alt="" class="w-full h-full object-cover">
            </div>
            <div id="prasmanan-modal-img-placeholder"
                class="w-full h-36 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 12h16M4 12a8 8 0 0016 0M4 12a2 2 0 012-2h12a2 2 0 012 2M9 6a3 3 0 016 0" />
                </svg>
            </div>

            <h3 class="font-bold text-lg" id="prasmanan-modal-title">Pesan Prasmanan</h3>
            <p class="text-sm opacity-60" id="prasmanan-modal-subtitle"></p>

            <form method="POST" action="{{ route('cart.store') }}" id="form-prasmanan">
                @csrf
                <input type="hidden" name="product_id" id="prasmanan-product-id">
                <input type="hidden" name="selected_menus" id="prasmanan-selected-menus">

                <div class="space-y-1 mb-4">
                    <label class="text-sm font-semibold">Jumlah Porsi</label>
                    <input type="number" name="quantity" id="prasmanan-qty" min="50" value="50"
                        class="input input-bordered w-full" required>
                    <p class="text-xs opacity-40">Minimal 50 porsi.</p>
                </div>

                <div class="space-y-3 mb-4">
                    <p class="font-bold text-sm">Add-on Gubukan <span class="font-normal opacity-40">(opsional)</span>
                    </p>
                    @foreach ($addonsGubukan as $addon)
                        <label
                            class="flex items-center gap-3 cursor-pointer rounded-xl border border-base-200 px-4 py-3 hover:bg-base-50 transition has-[:checked]:border-violet-400 has-[:checked]:bg-violet-50">
                            <input type="checkbox" name="_gubukan[]" value="{{ $addon['value'] }}"
                                class="checkbox checkbox-sm prasmanan-gubukan" style="accent-color:#7F77DD">
                            <span class="text-xl">{{ $addon['icon'] }}</span>
                            <div class="flex-1">
                                <p class="font-semibold text-sm">{{ $addon['label'] }}</p>
                                <p class="text-xs opacity-50">{{ $addon['desc'] }}</p>
                            </div>
                            <span class="text-sm font-bold" style="color:#534AB7">+ Rp
                                {{ number_format($addon['harga'], 0, ',', '.') }} / porsi</span>
                        </label>
                    @endforeach
                </div>

                <div class="rounded-xl bg-base-200 px-4 py-3 text-sm mb-4">
                    <div class="flex justify-between">
                        <span class="opacity-60">Estimasi total</span>
                        <span class="font-bold" id="prasmanan-preview-total">Rp 0</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('modal-prasmanan').close()"
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
        const addonPrasmananHarga = {
            bakso: 5000,
            dimsum: 6000,
            eskrim: 4500
        };
        let prasmananBasePrice = 0;

        function openPrasmananModal(productId, name, price, imgUrl) {
            prasmananBasePrice = price;
            document.getElementById('prasmanan-product-id').value = productId;
            document.getElementById('prasmanan-modal-title').textContent = name;
            document.getElementById('prasmanan-modal-subtitle').textContent = 'Rp ' + price.toLocaleString('id-ID') +
                ' / porsi';

            const imgWrap = document.getElementById('prasmanan-modal-img-wrap');
            const imgEl = document.getElementById('prasmanan-modal-img');
            const imgPlaceholder = document.getElementById('prasmanan-modal-img-placeholder');
            if (imgUrl) {
                imgEl.src = imgUrl;
                imgEl.alt = name;
                imgWrap.classList.remove('hidden');
                imgPlaceholder.classList.add('hidden');
            } else {
                imgWrap.classList.add('hidden');
                imgPlaceholder.classList.remove('hidden');
            }

            document.querySelectorAll('.prasmanan-gubukan').forEach(c => c.checked = false);
            document.getElementById('prasmanan-qty').value = 50;
            updatePrasmananPreview();
            document.getElementById('modal-prasmanan').showModal();
        }

        function updatePrasmananPreview() {
            const qty = parseInt(document.getElementById('prasmanan-qty').value) || 0;
            let addonPerPorsi = 0;
            document.querySelectorAll('.prasmanan-gubukan:checked').forEach(c => {
                addonPerPorsi += addonPrasmananHarga[c.value] || 0;
            });
            const total = (prasmananBasePrice + addonPerPorsi) * qty;
            document.getElementById('prasmanan-preview-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('prasmanan-qty').addEventListener('input', updatePrasmananPreview);
        document.querySelectorAll('.prasmanan-gubukan').forEach(c => c.addEventListener('change', updatePrasmananPreview));

        document.getElementById('form-prasmanan').addEventListener('submit', function() {
            const selectedMenus = {
                gubukan: [...document.querySelectorAll('.prasmanan-gubukan:checked')].map(c => c.value),
            };
            document.getElementById('prasmanan-selected-menus').value = JSON.stringify(selectedMenus);
        });
    </script>
</x-app-layout>
