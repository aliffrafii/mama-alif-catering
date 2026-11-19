<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Pesanan Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- HEADER --}}
            <div
                class="rounded-3xl bg-gradient-to-br from-[#6B7B3B] to-[#4E5C2C] shadow-xl p-6 sm:p-7 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-28 h-28 rounded-full bg-white/10"></div>
                <div class="relative flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-black text-white">Pesanan Saya</h1>
                            <p class="text-sm text-white/70 mt-0.5">{{ $orders->count() }} riwayat pesanan</p>
                        </div>
                    </div>
                    <a href="{{ route('customer.dashboard') }}"
                        class="hidden sm:inline-flex items-center gap-2 rounded-2xl bg-white/15 hover:bg-white/25 transition text-white text-sm font-semibold px-4 py-2.5 flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>

            {{-- Tombol kembali versi mobile --}}
            <a href="{{ route('customer.dashboard') }}" class="sm:hidden btn btn-outline rounded-2xl w-full gap-2">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>

            {{-- FILTER PER MENU --}}
            <div class="flex gap-2 overflow-x-auto pb-1 -mx-1 px-1">
                <a href="{{ route('orders.index') }}"
                    class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border transition
                        {{ !$kategori ? 'bg-[#2C2A1E] text-white border-[#2C2A1E]' : 'bg-base-100 text-base-content/60 border-base-200 hover:bg-base-200' }}">
                    Semua
                </a>
                <a href="{{ route('orders.index', ['kategori' => 'box']) }}"
                    class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border transition
                        {{ $kategori === 'box' ? 'bg-sky-500 text-white border-sky-500' : 'bg-base-100 text-base-content/60 border-base-200 hover:bg-sky-50' }}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 8l8-4 8 4M4 8v8l8 4m-8-12l8 4m0 8l8-4V8m-8 12V12" />
                    </svg>
                    Nasi Box
                </a>
                <a href="{{ route('orders.index', ['kategori' => 'prasmanan']) }}"
                    class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border transition
                        {{ $kategori === 'prasmanan' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-base-100 text-base-content/60 border-base-200 hover:bg-emerald-50' }}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 12h16M4 12a8 8 0 0016 0M4 12a2 2 0 012-2h12a2 2 0 012 2M9 6a3 3 0 016 0" />
                    </svg>
                    Prasmanan
                </a>
                <a href="{{ route('orders.index', ['kategori' => 'tumpeng']) }}"
                    class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border transition
                        {{ $kategori === 'tumpeng' ? 'bg-amber-500 text-white border-amber-500' : 'bg-base-100 text-base-content/60 border-base-200 hover:bg-amber-50' }}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 18H5L12 3zM9 14h6M10 18h4" />
                    </svg>
                    Nasi Tumpeng
                </a>
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

            @if (session('error'))
                <div class="alert bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($orders->isEmpty())
                <div class="rounded-2xl bg-base-100 shadow p-10 text-center space-y-3">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-base-200 flex items-center justify-center">
                        <svg class="w-8 h-8 opacity-30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="font-bold">{{ $kategori ? 'Belum ada pesanan di kategori ini' : 'Belum ada pesanan' }}
                    </p>
                    <p class="text-sm opacity-50">Yuk mulai pesan!</p>
                    <a href="{{ route('menu.nasi-box') }}"
                        class="btn btn-sm bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-xl">Lihat
                        Menu</a>
                </div>
            @else
                @foreach ($orders as $order)
                    @php
                        $statusConfig = [
                            'pending' => [
                                'label' => 'Menunggu Pembayaran',
                                'bg' => 'bg-amber-50',
                                'text' => 'text-amber-700',
                                'border' => 'border-amber-200',
                                'dot' => 'bg-amber-400',
                            ],
                            'confirmed' => [
                                'label' => 'Dikonfirmasi',
                                'bg' => 'bg-blue-50',
                                'text' => 'text-blue-700',
                                'border' => 'border-blue-200',
                                'dot' => 'bg-blue-400',
                            ],
                            'processing' => [
                                'label' => 'Diproses',
                                'bg' => 'bg-violet-50',
                                'text' => 'text-violet-700',
                                'border' => 'border-violet-200',
                                'dot' => 'bg-violet-400',
                            ],
                            'completed' => [
                                'label' => 'Selesai',
                                'bg' => 'bg-emerald-50',
                                'text' => 'text-emerald-700',
                                'border' => 'border-emerald-200',
                                'dot' => 'bg-emerald-500',
                            ],
                            'cancelled' => [
                                'label' => 'Dibatalkan',
                                'bg' => 'bg-red-50',
                                'text' => 'text-red-700',
                                'border' => 'border-red-200',
                                'dot' => 'bg-red-400',
                            ],
                        ];
                        $st = $statusConfig[$order->status] ?? [
                            'label' => $order->status,
                            'bg' => 'bg-base-200',
                            'text' => 'text-base-content',
                            'border' => 'border-base-300',
                            'dot' => 'bg-base-400',
                        ];

                        $warrantyHours = $order->status === 'completed' ? $order->warrantyHours() : null;
                    @endphp

                    <div
                        class="rounded-2xl bg-base-100 shadow-sm border border-base-200/60 overflow-hidden hover:shadow-md transition-shadow">

                        {{-- Header order --}}
                        <div class="px-5 pt-4 pb-3 flex items-start justify-between gap-3 border-b border-base-200">
                            <div>
                                <p class="font-bold text-sm font-mono tracking-tight">{{ $order->order_number }}</p>
                                <p class="text-xs opacity-40 mt-0.5">
                                    {{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 {{ $st['bg'] }} {{ $st['text'] }} border {{ $st['border'] }} px-3 py-1.5 rounded-full font-semibold text-xs">
                                <span class="w-1.5 h-1.5 rounded-full {{ $st['dot'] }}"></span>
                                {{ $st['label'] }}
                            </span>
                        </div>

                        {{-- Detail items --}}
                        <div class="px-5 py-4 space-y-4">

                            {{-- Info acara --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-xs">
                                <div class="flex items-center gap-2 opacity-60">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('d F Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2 opacity-60">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">{{ $order->delivery_address }}</span>
                                </div>
                                @if ($order->phone)
                                    <div class="flex items-center gap-2 opacity-60">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span>{{ $order->phone }}</span>
                                    </div>
                                @endif
                                @if ($order->notes)
                                    <div class="flex items-center gap-2 opacity-60 sm:col-span-2">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span class="italic">{{ $order->notes }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Daftar produk dari order_items --}}
                            @if ($order->orderItems && $order->orderItems->count() > 0)
                                <div class="space-y-2">
                                    @foreach ($order->orderItems as $item)
                                        @php
                                            $catId = $item->product->category_id ?? 0;
                                            $catColors = [
                                                1 => ['bg' => 'bg-sky-100', 'text' => 'text-sky-600'],
                                                2 => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
                                                3 => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600'],
                                            ];
                                            $catColor = $catColors[$catId] ?? [
                                                'bg' => 'bg-base-300',
                                                'text' => 'text-base-content/50',
                                            ];
                                            $catPaths = [
                                                1 => 'M4 8l8-4 8 4M4 8v8l8 4m-8-12l8 4m0 8l8-4V8m-8 12V12',
                                                2 => 'M4 12h16M4 12a8 8 0 0016 0M4 12a2 2 0 012-2h12a2 2 0 012 2M9 6a3 3 0 016 0',
                                                3 => 'M12 3l7 18H5L12 3zM9 14h6M10 18h4',
                                            ];
                                            $catPath = $catPaths[$catId] ?? 'M4 6h16M4 12h16M4 18h16';
                                            $sm = is_array($item->selected_menus)
                                                ? $item->selected_menus
                                                : json_decode($item->selected_menus, true) ?? [];
                                        @endphp
                                        <div class="rounded-xl bg-base-200/50 px-3.5 py-3 space-y-1.5">
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="flex items-center gap-2.5 min-w-0">
                                                    <div
                                                        class="w-7 h-7 rounded-lg {{ $catColor['bg'] }} flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-4 h-4 {{ $catColor['text'] }}"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="{{ $catPath }}" />
                                                        </svg>
                                                    </div>
                                                    <span
                                                        class="font-semibold text-sm truncate">{{ $item->product->name ?? 'Produk dihapus' }}</span>
                                                    <span class="text-xs opacity-50 flex-shrink-0">×
                                                        {{ $item->quantity }}</span>
                                                </div>
                                                <span class="text-sm font-bold flex-shrink-0">Rp
                                                    {{ number_format($item->price, 0, ',', '.') }}</span>
                                            </div>

                                            @if (!empty($sm))
                                                <div class="pl-9 space-y-1 text-xs opacity-60">
                                                    @if (!empty($sm['menu_utama']))
                                                        <p class="flex items-center gap-1.5">
                                                            <span
                                                                class="w-1 h-1 rounded-full bg-current opacity-50"></span>
                                                            {{ ucwords(str_replace('_', ' ', $sm['menu_utama'])) }}
                                                        </p>
                                                    @endif
                                                    @if (!empty($sm['isian']))
                                                        <p class="flex items-center gap-1.5">
                                                            <span
                                                                class="w-1 h-1 rounded-full bg-current opacity-50"></span>
                                                            {{ collect($sm['isian'])->map(fn($v) => ucwords(str_replace('_', ' ', $v)))->implode(', ') }}
                                                        </p>
                                                    @endif
                                                    @if (!empty($sm['tambahan']))
                                                        <p class="flex items-center gap-1.5">
                                                            <span
                                                                class="w-1 h-1 rounded-full bg-current opacity-50"></span>
                                                            {{ collect($sm['tambahan'])->map(fn($v) => ucwords(str_replace('_', ' ', $v)))->implode(', ') }}
                                                        </p>
                                                    @endif
                                                    @if (!empty($sm['gubukan']))
                                                        <p class="flex items-center gap-1.5">
                                                            <span
                                                                class="w-1 h-1 rounded-full bg-current opacity-50"></span>
                                                            Gubukan:
                                                            {{ collect($sm['gubukan'])->map(fn($v) => ucwords($v))->implode(', ') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                @if ($order->notes)
                                    <p class="text-xs opacity-50 italic px-1">{{ $order->notes }}</p>
                                @endif
                            @endif

                            {{-- Total --}}
                            <div class="space-y-1.5 pt-1">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="opacity-60">Subtotal</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($order->total_price - ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
                                </div>
                                @if (!empty($order->shipping_cost) && $order->shipping_cost > 0)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="opacity-60 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 13h13V6H3v7zm0 0l3 5h7l3-5m-13 0h13m4 0h1a1 1 0 001-1V9.5a1 1 0 00-.29-.71l-2.5-2.5A1 1 0 0018.5 6H16v7z" />
                                            </svg>
                                            Ongkos Kirim
                                        </span>
                                        <span class="font-semibold text-blue-600">Rp
                                            {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center pt-2 border-t border-base-200">
                                    <span class="text-sm font-bold">Total</span>
                                    <span class="font-black text-base text-[#6B7B3B]">Rp
                                        {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Footer: aksi --}}
                        @if ($order->status === 'pending' || $order->status === 'completed')
                            <div class="px-5 pb-4 flex flex-wrap gap-2">

                                @if ($order->status === 'pending')
                                    <a href="{{ route('payment.retry', $order) }}"
                                        class="btn btn-sm bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-xl flex-1 gap-1.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Bayar Sekarang
                                    </a>
                                @endif

                                @if ($order->status === 'completed')
                                    @if ($order->rating)
                                        <div
                                            class="flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-3.5 h-3.5 {{ $i <= $order->rating ? 'text-amber-400' : 'text-gray-300' }}"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.813 9.385c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.958z" />
                                                </svg>
                                            @endfor
                                            <span
                                                class="text-xs text-amber-600 ml-1 font-semibold">{{ $order->rating }}/5</span>
                                        </div>
                                        @if ($order->review)
                                            <p class="w-full text-xs opacity-50 italic px-1">"{{ $order->review }}"
                                            </p>
                                        @endif
                                    @else
                                        <a href="{{ route('order.rating', $order) }}"
                                            class="btn btn-sm bg-amber-400 hover:bg-amber-500 text-white border-none rounded-xl gap-1.5">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.287 3.957c.3.922-.755 1.688-1.539 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.813 9.385c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.958z" />
                                            </svg>
                                            Beri Rating
                                        </a>
                                    @endif

                                    @if ($warrantyHours)
                                        <div class="w-full">
                                            @if ($order->warranty_claimed_at)
                                                @php $wStatus = $order->warrantyStatusConfig(); @endphp
                                                <div
                                                    class="rounded-xl bg-red-50 border border-red-200 px-3.5 py-3 text-xs space-y-2">
                                                    <div class="flex items-center justify-between flex-wrap gap-1.5">
                                                        <p
                                                            class="font-semibold text-red-700 flex items-center gap-1.5">
                                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor"
                                                                stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M21 12c0 5.5-3.8 9.9-9 11-5.2-1.1-9-5.5-9-11V6l9-4 9 4v6z" />
                                                            </svg>
                                                            Keluhan Terkirim
                                                        </p>
                                                        <span
                                                            class="font-semibold px-2 py-0.5 rounded-full border {{ $wStatus['bg'] }} {{ $wStatus['text'] }} {{ $wStatus['border'] }}">
                                                            {{ $wStatus['label'] }}
                                                        </span>
                                                    </div>
                                                    <p class="opacity-70 italic">"{{ $order->warranty_note }}"</p>

                                                    @if ($order->warranty_response)
                                                        <div class="bg-white/70 rounded-lg p-2.5 mt-1">
                                                            <p class="font-semibold text-red-700 mb-0.5">Tanggapan
                                                                dari Mama Alif Catering</p>
                                                            <p class="opacity-80">{{ $order->warranty_response }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif ($order->isWarrantyActive())
                                                <button type="button"
                                                    onclick="document.getElementById('warranty-modal-{{ $order->id_order }}').showModal()"
                                                    class="inline-flex items-center gap-2 rounded-xl bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 text-xs font-semibold px-3.5 py-2.5 transition w-full sm:w-auto">
                                                    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                    <span class="text-left">
                                                        Ada keluhan? (makanan basi, kurang sesuai, dll)
                                                        <span
                                                            class="block font-normal opacity-70 normal-case">{{ $order->warrantyTimeLeftLabel() }}</span>
                                                    </span>
                                                </button>

                                                <dialog id="warranty-modal-{{ $order->id_order }}" class="modal">
                                                    <div class="modal-box rounded-2xl">
                                                        <h3 class="font-bold text-lg">Laporkan Keluhan Pesanan</h3>
                                                        <p class="text-xs opacity-60 mt-1">
                                                            Berlaku sampai
                                                            {{ $order->warrantyDeadline()->translatedFormat('d F Y, H:i') }}
                                                        </p>
                                                        <form method="POST"
                                                            action="{{ route('order.warranty', $order) }}"
                                                            class="mt-4 space-y-3">
                                                            @csrf
                                                            <textarea name="warranty_note" required rows="4"
                                                                placeholder="Ceritakan keluhannya, misalnya makanan basi, kurang matang, porsi tidak sesuai, atau ada bahan yang hilang..."
                                                                class="textarea textarea-bordered w-full rounded-xl text-sm"></textarea>
                                                            <div class="flex gap-2 pt-1">
                                                                <button type="button"
                                                                    onclick="document.getElementById('warranty-modal-{{ $order->id_order }}').close()"
                                                                    class="flex-1 rounded-xl border border-base-300 text-sm font-semibold py-2.5 hover:bg-base-200 transition">
                                                                    Batal
                                                                </button>
                                                                <button type="submit"
                                                                    class="flex-1 rounded-xl bg-[#6B7B3B] hover:bg-[#5A6932] text-white text-sm font-semibold py-2.5 transition flex items-center justify-center gap-1.5">
                                                                    <svg class="w-4 h-4" viewBox="0 0 24 24"
                                                                        fill="none" stroke="currentColor"
                                                                        stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                                    </svg>
                                                                    Kirim
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </dialog>
                                            @else
                                                <p class="text-xs opacity-40 italic px-1">Masa laporan keluhan sudah
                                                    berakhir</p>
                                            @endif
                                        </div>
                                    @endif
                                @endif

                            </div>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>
