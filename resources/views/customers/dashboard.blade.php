<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 py-6">

        {{-- HERO --}}
        <div class="rounded-3xl bg-gradient-to-br from-[#6B7B3B] to-[#4E5C2C] shadow-xl p-8 relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white/5"></div>
            <div class="absolute -right-2 top-16 w-24 h-24 rounded-full bg-white/5"></div>
            <div class="relative">
                <p class="text-white/70 text-xs font-semibold uppercase tracking-widest">Customer Dashboard</p>
                <h1 class="text-3xl font-black text-white mt-1">Halo, {{ auth()->user()->name }} 👋</h1>
                <p class="text-white/70 mt-2 text-sm">Yuk lihat progres pesananmu atau pilih menu baru untuk acara
                    selanjutnya.</p>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <div class="rounded-2xl bg-base-100 shadow p-5 border-l-4 border-[#6B7B3B] flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-[#6B7B3B]/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-[#6B7B3B]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs opacity-50 uppercase font-semibold tracking-wide">Total Pesanan</p>
                    <p class="text-3xl font-black mt-0.5">{{ $totalOrders }}</p>
                </div>
            </div>

            <div class="rounded-2xl bg-base-100 shadow p-5 border-l-4 border-amber-400 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs opacity-50 uppercase font-semibold tracking-wide">Menunggu Pembayaran</p>
                    <p class="text-3xl font-black mt-0.5 text-amber-500">{{ $pendingOrders }}</p>
                </div>
            </div>

            <div class="rounded-2xl bg-base-100 shadow p-5 border-l-4 border-emerald-500 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs opacity-50 uppercase font-semibold tracking-wide">Sudah Dibayar</p>
                    <p class="text-3xl font-black mt-0.5 text-emerald-600">{{ $confirmedOrders }}</p>
                </div>
            </div>

        </div>

        {{-- PILIH MENU --}}
        <div>
            <p class="font-bold text-sm mb-3 opacity-70">Pilih Menu</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <a href="{{ route('menu.nasi-box') }}"
                    class="group rounded-2xl bg-base-100 shadow p-5 hover:shadow-lg hover:-translate-y-0.5 transition flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center flex-shrink-0 group-hover:bg-sky-500 transition-colors">
                        <svg class="w-6 h-6 text-sky-600 group-hover:text-white transition-colors" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 8l8-4 8 4M4 8v8l8 4m-8-12l8 4m0 8l8-4V8m-8 12V12" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Nasi Box</p>
                        <p class="text-xs opacity-50">Lihat paket nasi box</p>
                    </div>
                </a>

                <a href="{{ route('menu.prasmanan') }}"
                    class="group rounded-2xl bg-base-100 shadow p-5 hover:shadow-lg hover:-translate-y-0.5 transition flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500 transition-colors">
                        <svg class="w-6 h-6 text-emerald-600 group-hover:text-white transition-colors"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 12h16M4 12a8 8 0 0016 0M4 12a2 2 0 012-2h12a2 2 0 012 2M9 6a3 3 0 016 0" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Prasmanan</p>
                        <p class="text-xs opacity-50">Lihat paket prasmanan</p>
                    </div>
                </a>

                <a href="{{ route('menu.nasi-tumpeng') }}"
                    class="group rounded-2xl bg-base-100 shadow p-5 hover:shadow-lg hover:-translate-y-0.5 transition flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                        <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3l7 18H5L12 3zM9 14h6M10 18h4" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Nasi Tumpeng</p>
                        <p class="text-xs opacity-50">Lihat paket tumpeng</p>
                    </div>
                </a>

            </div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <a href="{{ route('cart.index') }}"
                class="group rounded-2xl bg-[#2C2A1E] shadow p-5 hover:shadow-lg transition flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-[#6B7B3B] transition-colors">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-sm text-white">Keranjang Saya</p>
                    <p class="text-xs text-white/50">Lihat item yang belum dipesan</p>
                </div>
                <svg class="w-4 h-4 text-white/30 ml-auto group-hover:text-white group-hover:translate-x-0.5 transition"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <a href="{{ route('orders.index') }}"
                class="group rounded-2xl bg-[#2C2A1E] shadow p-5 hover:shadow-lg transition flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-[#6B7B3B] transition-colors">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-sm text-white">Pesanan Saya</p>
                    <p class="text-xs text-white/50">Lihat riwayat & bayar pesanan</p>
                </div>
                <svg class="w-4 h-4 text-white/30 ml-auto group-hover:text-white group-hover:translate-x-0.5 transition"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>

        </div>

    </div>

</x-app-layout>
