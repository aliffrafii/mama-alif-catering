<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <!-- Brand -->
            <div class="flex items-center gap-3">
                <!-- Logo (placeholder) -->
                <div class="avatar">
                    <div
                        class="w-11 rounded-xl bg-gradient-to-br from-primary to-secondary text-primary-content grid place-items-center shadow">
                        <span class="font-black tracking-wide">MA</span>
                    </div>
                </div>

                <div class="leading-tight">
                    <h2 class="text-xl font-extrabold text-base-content">
                        Catering Mama Alif
                    </h2>
                    <p class="text-xs opacity-70">
                        Dashboard • Kelola menu, pesanan, dan pelanggan
                    </p>
                </div>
            </div>

            <!-- User / Actions -->
            <div class="flex items-center gap-2 sm:justify-end">
                <div class="hidden sm:flex items-center gap-2">
                    <div class="badge badge-primary badge-outline">
                        {{ auth()->user()->role ?? 'user' }}
                    </div>
                    <div class="badge badge-ghost">
                        {{ auth()->user()->email }}
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline btn-error">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Hero / Welcome -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary to-secondary text-primary-content shadow">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-2xl sm:text-3xl font-black">
                                Selamat datang, {{ auth()->user()->name }}!
                            </h3>
                            <p class="mt-1 text-sm sm:text-base opacity-90">
                                Siap menerima pesanan hari ini? Pantau performa dan kelola operasional dari sini.
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ url('/') }}"
                                class="btn btn-sm btn-ghost text-primary-content border border-white/30">
                                Lihat Website
                            </a>
                            <a href="#ringkasan" class="btn btn-sm btn-neutral">
                                Ringkasan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Decorative blobs -->
                <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/15 blur-2xl">
                </div>
                <div
                    class="pointer-events-none absolute -left-10 -bottom-10 h-48 w-48 rounded-full bg-black/10 blur-2xl">
                </div>
            </div>

            <!-- Quick Stats (dummy placeholders) -->
            <div id="ringkasan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="card bg-base-100 shadow hover:shadow-lg transition">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-wide opacity-60">Pesanan Hari Ini</p>
                                <p class="text-2xl font-extrabold">—</p>
                            </div>
                            <div class="btn btn-circle btn-sm btn-primary btn-outline">
                                <!-- icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2Zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2ZM7.17 14h9.66c.75 0 1.41-.41 1.75-1.03L21 6H6.21L5.27 4H2v2h2l3.6 7.59-1.35 2.44C5.52 17.37 6.48 19 8 19h12v-2H8l1.17-2Z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm opacity-70 mt-2">Ringkasan akan muncul setelah data terhubung.</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow hover:shadow-lg transition">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-wide opacity-60">Total Menu</p>
                                <p class="text-2xl font-extrabold">—</p>
                            </div>
                            <div class="btn btn-circle btn-sm btn-secondary btn-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M12 2a10 10 0 1 0 10 10A10.01 10.01 0 0 0 12 2Zm1 14.93V20h-2v-3.07A8 8 0 0 1 4.07 13H7v-2H4.07A7.97 7.97 0 0 1 11 4.07V7h2V4.07A7.97 7.97 0 0 1 19.93 11H17v2h2.93A8 8 0 0 1 13 16.93Z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm opacity-70 mt-2">Kelola menu harian & paket catering.</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow hover:shadow-lg transition">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-wide opacity-60">Pelanggan</p>
                                <p class="text-2xl font-extrabold">—</p>
                            </div>
                            <div class="btn btn-circle btn-sm btn-accent btn-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3Zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13Zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5C23 14.17 18.33 13 16 13Z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm opacity-70 mt-2">Pantau pelanggan dan alamat pengiriman.</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow hover:shadow-lg transition">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-wide opacity-60">Pendapatan</p>
                                <p class="text-2xl font-extrabold">—</p>
                            </div>
                            <div class="btn btn-circle btn-sm btn-success btn-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M12 1a11 11 0 1 0 11 11A11.013 11.013 0 0 0 12 1Zm1 17.93V20h-2v-1.07A4 4 0 0 1 8 15h2a2 2 0 0 0 4 0c0-1.1-1.34-1.5-3-1.9-1.78-.43-4-1-4-3.1a4 4 0 0 1 3-3.86V4h2v1.07A4 4 0 0 1 16 9h-2a2 2 0 0 0-4 0c0 1 1.18 1.34 2.77 1.72C14.63 11.18 17 11.8 17 15a4 4 0 0 1-4 3.93Z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm opacity-70 mt-2">Lihat laporan omzet per hari/bulan.</p>
                    </div>
                </div>
            </div>

            <!-- Main Content (Livewire) -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between gap-3">
                        <h3 class="text-lg font-bold">Konten Utama</h3>
                        <div class="join">
                            <button class="btn btn-sm join-item btn-outline">Menu</button>
                            <button class="btn btn-sm join-item btn-outline">Orders</button>
                            <button class="btn btn-sm join-item btn-outline">Customers</button>
                        </div>
                    </div>

                    <div class="divider my-3"></div>

                    <livewire:dashboard />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
