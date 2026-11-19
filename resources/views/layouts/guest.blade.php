<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="mamaalif">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Catering Mama Alif') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5F0E8]">
    @php
        use App\Models\Order;
        use App\Models\Category;

        $totalPesanan = Order::where('status', 'completed')->count();
        $totalKategori = Category::where('is_active', 1)->count();
        $avgRating = Order::whereNotNull('rating')->avg('rating');
        $avgRating = $avgRating ? number_format($avgRating, 1) : '5.0';

        $previewTumpeng = \App\Models\Product::where('category_id', 3)
            ->where('is_active', 1)
            ->orderBy('price')
            ->take(3)
            ->get();
        $previewBox = \App\Models\Product::where('category_id', 1)->where('is_active', 1)->orderBy('price')->get();
        $previewPrasmanan = \App\Models\Product::where('category_id', 2)
            ->where('is_active', 1)
            ->orderBy('price')
            ->get();
        $authRoutes = ['login', 'register', 'password.request', 'password.email', 'password.reset', 'password.confirm'];
        $openLogin = $errors->any() || session('status') || request()->routeIs($authRoutes);

        $imgTumpeng = \App\Models\Product::where('category_id', 3)
            ->where('is_active', 1)
            ->whereNotNull('image')
            ->value('image');
        $imgBox = \App\Models\Product::where('category_id', 1)
            ->where('is_active', 1)
            ->whereNotNull('image')
            ->value('image');
        $imgPrasmanan = \App\Models\Product::where('category_id', 2)
            ->where('is_active', 1)
            ->whereNotNull('image')
            ->value('image');

        $resolveImg = fn($img) => $img
            ? (\Illuminate\Support\Str::startsWith($img, 'http')
                ? $img
                : asset('storage/' . $img))
            : null;

        // Path SVG untuk tiap kategori (konsisten dengan halaman menu)
        $iconTumpeng = 'M12 3l7 18H5L12 3zM9 14h6M10 18h4';
        $iconBox = 'M4 8l8-4 8 4M4 8v8l8 4m-8-12l8 4m0 8l8-4V8m-8 12V12';
        $iconPrasmanan = 'M4 12h16M4 12a8 8 0 0016 0M4 12a2 2 0 012-2h12a2 2 0 012 2M9 6a3 3 0 016 0';
    @endphp

    {{-- NAVBAR --}}
    <nav class="fixed top-0 inset-x-0 z-30 bg-[#F5F0E8]/80 backdrop-blur-md border-b border-black/5">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-xl bg-white shadow ring-1 ring-black/10 overflow-hidden grid place-items-center">
                    <img src="{{ asset('brand/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                </div>
                <span class="font-black text-base tracking-tight text-[#2C2A1E]">Mama Alif Catering</span>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="scrollKeMenu()"
                    class="hidden sm:inline-flex items-center gap-1.5 rounded-full border border-[#6B7B3B] text-[#6B7B3B] text-sm font-semibold px-5 py-2 hover:bg-[#6B7B3B]/10 transition">
                    Lihat Menu
                </button>
                <button type="button" onclick="openLoginModal()"
                    class="inline-flex items-center gap-2 rounded-full bg-[#6B7B3B] text-white text-sm font-semibold px-5 py-2 shadow hover:bg-[#5A6932] active:scale-95 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                        <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                        <path d="M6 11h12v10H6V11Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    </svg>
                    Login
                </button>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="pt-28 pb-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                {{-- Teks kiri --}}
                <div class="space-y-6">
                    <div class="flex flex-wrap gap-2">
                        <div class="inline-flex items-center gap-2 rounded-full bg-[#6B7B3B]/10 px-4 py-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#6B7B3B] animate-pulse"></span>
                            <span class="text-xs font-semibold text-[#4E5C2C] tracking-wide">Buka & menerima
                                pesanan</span>
                        </div>
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-white border border-black/8 px-4 py-1.5">
                            <svg class="w-3.5 h-3.5 text-[#6B7B3B]" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs font-semibold text-[#4E5C2C]">Area <span
                                    class="text-[#6B7B3B]">Bekasi</span> & <span
                                    class="text-[#6B7B3B]">Jakarta</span></span>
                        </div>
                    </div>

                    <h1 class="text-5xl font-black leading-[1.1] tracking-tight text-[#2C2A1E]">
                        Masakan rumah,<br>
                        <span class="text-[#6B7B3B]">rasa istimewa.</span>
                    </h1>

                    <p class="text-base text-[#6B6A5E] leading-relaxed max-w-sm">
                        Tumpeng syukuran, nasi box rapat, sampai prasmanan 200 porsi — kami siapkan dengan bahan segar
                        dan bumbu khas sendiri.
                    </p>

                    <div class="flex flex-wrap gap-3 pt-1">
                        <button type="button" onclick="openLoginModal()"
                            class="rounded-2xl bg-[#2C2A1E] px-7 py-3.5 text-sm font-bold text-white hover:bg-[#3D3B2E] active:scale-95 transition">
                            Pesan Sekarang
                        </button>
                        <button type="button" onclick="scrollKeMenu()"
                            class="group rounded-2xl border-2 border-[#2C2A1E]/15 bg-transparent px-7 py-3.5 text-sm font-bold text-[#2C2A1E] hover:border-[#2C2A1E]/30 transition flex items-center gap-2">
                            Jelajahi Menu
                            <svg class="w-4 h-4 group-hover:translate-y-0.5 transition-transform" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex gap-8 pt-2 border-t border-black/8">
                        <div>
                            <p class="text-2xl font-black text-[#2C2A1E]">{{ $totalPesanan }}</p>
                            <p class="text-xs text-[#6B6A5E] mt-0.5">Pesanan selesai</p>
                        </div>
                        <div class="w-px bg-black/8"></div>
                        <div>
                            <p class="text-2xl font-black text-[#2C2A1E]">{{ $totalKategori }}</p>
                            <p class="text-xs text-[#6B6A5E] mt-0.5">Kategori menu</p>
                        </div>
                        <div class="w-px bg-black/8"></div>
                        <div>
                            <p class="text-2xl font-black text-[#2C2A1E]">{{ $avgRating }}
                                <svg class="w-4 h-4 inline text-[#6B7B3B] -mt-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.813 9.385c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.958z" />
                                </svg>
                            </p>
                            <p class="text-xs text-[#6B6A5E] mt-0.5">Rating pelanggan</p>
                        </div>
                    </div>
                </div>

                {{-- Grid gambar kanan --}}
                <div class="hidden lg:grid grid-cols-2 gap-3">

                    <div onclick="scrollKeMenu()"
                        class="group relative rounded-3xl overflow-hidden aspect-square cursor-pointer bg-amber-100">
                        @if ($resolveImg($imgTumpeng))
                            <img src="{{ $resolveImg($imgTumpeng) }}" alt="Nasi Tumpeng"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-amber-400" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconTumpeng }}" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <p class="text-white text-xs font-semibold opacity-80">Kategori</p>
                            <p class="text-white text-sm font-black">Nasi Tumpeng</p>
                        </div>
                    </div>

                    <div onclick="scrollKeMenu()"
                        class="group relative rounded-3xl overflow-hidden aspect-square cursor-pointer bg-sky-100 mt-6">
                        @if ($resolveImg($imgBox))
                            <img src="{{ $resolveImg($imgBox) }}" alt="Nasi Box"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-sky-400" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconBox }}" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <p class="text-white text-xs font-semibold opacity-80">Kategori</p>
                            <p class="text-white text-sm font-black">Nasi Box</p>
                        </div>
                    </div>

                    <div onclick="scrollKeMenu()"
                        class="group relative rounded-3xl overflow-hidden aspect-square cursor-pointer bg-emerald-100 -mt-6">
                        @if ($resolveImg($imgPrasmanan))
                            <img src="{{ $resolveImg($imgPrasmanan) }}" alt="Prasmanan"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-emerald-400" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPrasmanan }}" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <p class="text-white text-xs font-semibold opacity-80">Kategori</p>
                            <p class="text-white text-sm font-black">Prasmanan</p>
                        </div>
                    </div>

                    <div onclick="scrollKeMenu()"
                        class="group relative rounded-3xl overflow-hidden aspect-square cursor-pointer bg-[#2C2A1E] flex flex-col items-center justify-center gap-3 p-6 text-center hover:bg-[#3D3B2E] transition">
                        <div
                            class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none">
                                <path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-black text-lg leading-tight">Lihat<br>Semua Menu</p>
                            <p class="text-white/50 text-xs mt-1">3 kategori tersedia</p>
                        </div>
                        <div
                            class="absolute bottom-4 right-4 w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-[#6B7B3B] transition">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none">
                                <path d="M12 5v14M5 12l7 7 7-7" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- MENU --}}
    <section id="section-menu" class="pb-24 px-6 scroll-mt-20">
        <div class="max-w-6xl mx-auto space-y-14">

            <div class="text-center space-y-1">
                <p class="text-xs font-bold uppercase tracking-widest text-[#6B7B3B]">Menu Kami</p>
                <h2 class="text-3xl font-black text-[#2C2A1E]">Pilih yang Kamu Suka</h2>
            </div>

            {{-- NASI TUMPENG --}}
            <div class="space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconTumpeng }}" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-[#2C2A1E]">Nasi Tumpeng</h3>
                        <p class="text-xs text-[#6B6A5E]">Cocok untuk syukuran &amp; perayaan</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse ($previewTumpeng as $produk)
                        <div onclick="openLoginModal()"
                            class="group rounded-3xl bg-white border border-black/5 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 cursor-pointer transition duration-200">
                            <div class="h-40 bg-amber-50 flex items-center justify-center overflow-hidden">
                                @if ($produk->image)
                                    <img src="{{ $resolveImg($produk->image) }}" alt="{{ $produk->name }}"
                                        class="h-40 w-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <svg class="w-12 h-12 text-amber-300" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="{{ $iconTumpeng }}" />
                                    </svg>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-sm font-bold text-[#2C2A1E] leading-tight line-clamp-2">
                                    {{ $produk->name }}</p>
                                <p class="text-base font-black mt-1.5 text-[#6B7B3B]">
                                    Rp {{ number_format($produk->price, 0, ',', '.') }}
                                </p>
                                <span
                                    class="mt-2 inline-block text-[10px] font-semibold bg-amber-100 text-amber-800 rounded-full px-2 py-0.5">
                                    Login untuk pesan →
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#6B6A5E] italic col-span-full">Belum ada paket tersedia.</p>
                    @endforelse
                </div>
            </div>

            {{-- NASI BOX --}}
            <div class="space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconBox }}" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-[#2C2A1E]">Nasi Box</h3>
                        <p class="text-xs text-[#6B6A5E]">Praktis untuk rapat &amp; acara kantor</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse ($previewBox as $produk)
                        <div onclick="openLoginModal()"
                            class="group rounded-3xl bg-white border border-black/5 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 cursor-pointer transition duration-200">
                            <div class="h-40 bg-sky-50 flex items-center justify-center overflow-hidden">
                                @if ($produk->image)
                                    <img src="{{ $resolveImg($produk->image) }}" alt="{{ $produk->name }}"
                                        class="h-40 w-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <svg class="w-12 h-12 text-sky-300" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="{{ $iconBox }}" />
                                    </svg>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-sm font-bold text-[#2C2A1E] leading-tight">{{ $produk->name }}</p>
                                @if (!empty($produk->menu_options['max_isian']))
                                    <p class="text-xs text-[#6B6A5E] mt-0.5">{{ $produk->menu_options['max_isian'] }}
                                        isian pilihan</p>
                                @endif
                                <p class="text-base font-black mt-1.5 text-[#6B7B3B]">
                                    Rp {{ number_format($produk->price, 0, ',', '.') }}
                                </p>
                                <span
                                    class="mt-2 inline-block text-[10px] font-semibold bg-sky-100 text-sky-800 rounded-full px-2 py-0.5">
                                    Login untuk pesan →
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#6B6A5E] italic col-span-full">Belum ada paket tersedia.</p>
                    @endforelse
                </div>
            </div>

            {{-- PRASMANAN --}}
            <div class="space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPrasmanan }}" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-[#2C2A1E]">Prasmanan</h3>
                        <p class="text-xs text-[#6B6A5E]">Minimum 50 porsi · Per porsi</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse ($previewPrasmanan as $produk)
                        <div onclick="openLoginModal()"
                            class="group rounded-3xl bg-white border border-black/5 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 cursor-pointer transition duration-200">
                            <div class="h-40 bg-emerald-50 flex items-center justify-center overflow-hidden">
                                @if ($produk->image)
                                    <img src="{{ $resolveImg($produk->image) }}" alt="{{ $produk->name }}"
                                        class="h-40 w-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <svg class="w-12 h-12 text-emerald-300" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="{{ $iconPrasmanan }}" />
                                    </svg>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-sm font-bold text-[#2C2A1E] leading-tight">{{ $produk->name }}</p>
                                <p class="text-xs text-[#6B6A5E] mt-0.5">per porsi</p>
                                <p class="text-base font-black mt-1.5 text-[#6B7B3B]">
                                    Rp {{ number_format($produk->price, 0, ',', '.') }}
                                </p>
                                <span
                                    class="mt-2 inline-block text-[10px] font-semibold bg-emerald-100 text-emerald-800 rounded-full px-2 py-0.5">
                                    Login untuk pesan →
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#6B6A5E] italic col-span-full">Belum ada paket tersedia.</p>
                    @endforelse
                </div>
            </div>

            {{-- CTA BANNER --}}
            <div class="rounded-3xl bg-[#2C2A1E] p-10 text-center space-y-4">
                <p class="text-2xl font-black text-white">Siap memesan untuk acara Anda?</p>
                <p class="text-sm text-white/50">Daftar gratis dan mulai pesan dalam 2 menit</p>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 px-4 py-1.5">
                    <svg class="w-3.5 h-3.5 text-white/60" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-xs text-white/60">Pengiriman khusus area <span
                            class="text-white font-semibold">Bekasi</span> & <span
                            class="text-white font-semibold">Jakarta</span></span>
                </div>
                <div class="flex gap-3 justify-center pt-1">
                    <button type="button" onclick="openLoginModal()"
                        class="rounded-2xl bg-[#6B7B3B] text-white px-6 py-3 text-sm font-bold hover:bg-[#5A6932] active:scale-95 transition shadow">
                        Login
                    </button>
                    <a href="{{ route('register') }}"
                        class="rounded-2xl border border-white/20 text-white px-6 py-3 text-sm font-bold hover:bg-white/10 transition">
                        Daftar Sekarang
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-black/5 py-6 text-center text-xs text-[#6B6A5E]">
        © {{ date('Y') }} Catering Mama Alif · Melayani area Bekasi & Jakarta · Dengan login, Anda menyetujui
        ketentuan layanan kami.
    </footer>

    {{-- MODAL LOGIN --}}
    <div id="login-overlay"
        class="{{ $openLogin ? '' : 'hidden' }} fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        onclick="if (event.target === this) closeLoginModal()">
        <div class="w-full max-w-sm bg-[#F5F0E8] rounded-3xl shadow-2xl p-6 space-y-5 relative">
            <button type="button" onclick="closeLoginModal()"
                class="absolute top-4 right-4 opacity-40 hover:opacity-100 transition">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 6l12 12M6 18L18 6" stroke-linecap="round" />
                </svg>
            </button>
            {{ $slot }}
        </div>
    </div>

    <script>
        function openLoginModal() {
            document.getElementById('login-overlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                const emailInput = document.querySelector('#login-overlay input[name="email"]');
                if (emailInput) emailInput.focus();
            }, 50);
        }

        function closeLoginModal() {
            document.getElementById('login-overlay').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function scrollKeMenu() {
            document.getElementById('section-menu').scrollIntoView({
                behavior: 'smooth'
            });
        }

        @if ($openLogin)
            document.addEventListener('DOMContentLoaded', () => openLoginModal());
        @endif
    </script>
</body>

</html>
