<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-base-200 to-base-300 flex items-center justify-center py-12 px-4">

        <div class="max-w-md w-full">
            <div class="bg-base-100 rounded-3xl shadow-xl overflow-hidden border border-base-200">

                <!-- Header -->
                <div class="px-8 pt-8 pb-6 text-center">
                    <div class="mx-auto w-16 h-16 bg-success/10 rounded-2xl flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-success" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold text-base-content">
                        Pembayaran Berhasil
                    </h2>

                    <p class="text-base-content/60 mt-1">
                        Order ID:
                        <span class="font-mono">
                            {{ $order->order_number }}
                        </span>
                    </p>
                </div>

                <!-- Nominal Dibayar -->
                <div class="px-8 py-10 text-center border-t border-b border-base-200">
                    <span class="text-xs font-semibold tracking-widest text-base-content/50 uppercase">
                        Nominal Dibayarkan
                    </span>

                    <h1 class="text-5xl font-bold text-success mt-3 tracking-tighter">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </h1>


                </div>

                <!-- Informasi -->
                <div class="px-8 py-6 text-center">
                    <p class="text-base-content/70">
                        Terima kasih. Pembayaran Anda telah berhasil diverifikasi dan pesanan sedang diproses.
                    </p>
                </div>

                <!-- Button -->
                <div class="p-8 pt-0">
                    <a href="{{ route('customer.dashboard') }}"
                        class="btn btn btn-block h-14 rounded-2xl text-lg font-semibold shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all duration-300">
                        Kembali ke Dashboard
                    </a>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
