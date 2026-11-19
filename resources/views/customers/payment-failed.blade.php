<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-base-200 to-base-300 flex items-center justify-center py-12 px-4">

        <div class="max-w-md w-full">
            <div class="bg-base-100 rounded-3xl shadow-xl overflow-hidden border border-base-200">

                <!-- Header -->
                <div class="px-8 pt-8 pb-6 text-center">
                    <div class="mx-auto w-16 h-16 bg-error/10 rounded-2xl flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-error" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold text-base-content">
                        Pembayaran Gagal
                    </h2>

                    <p class="text-base-content/60 mt-1">
                        Transaksi tidak dapat diselesaikan.
                    </p>
                </div>

                <!-- Informasi -->
                <div class="px-8 py-10 text-center border-t border-b border-base-200">
                    <p class="text-base-content/70">
                        Pembayaran kamu gagal atau waktu pembayaran telah habis.
                        Silakan coba lagi atau hubungi kami jika masalah berlanjut.
                    </p>
                </div>

                <!-- Button -->
                <div class="p-8 pt-0 space-y-2">
                    <a href="{{ route('orders.index') }}"
                        class="btn btn-primary btn-block h-14 rounded-2xl text-lg font-semibold shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all duration-300">
                        Lihat Pesanan Saya
                    </a>
                    <a href="{{ route('payment.retry', $order->id) }}"
                        class="btn btn-primary btn-block h-14 rounded-2xl text-lg font-semibold">
                        Coba Bayar Lagi
                    </a>
                    <a href="{{ route('customer.dashboard') }}"
                        class="btn btn-ghost btn-block rounded-2xl text-base-content/60">
                        Kembali ke Dashboard
                    </a>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
