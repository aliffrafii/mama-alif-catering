<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-base-200 to-base-300 flex items-center justify-center py-12 px-4">

        <div class="max-w-md w-full">
            <div class="bg-base-100 rounded-3xl shadow-xl overflow-hidden border border-base-200">

                <!-- Header -->
                <div class="px-8 pt-8 pb-6 text-center">
                    <div class="mx-auto w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.25">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold text-base-content">Pembayaran Pesanan</h2>
                    <p class="text-base-content/60 mt-1">
                        Order ID: <span class="font-mono">{{ $order->order_number }}</span>
                    </p>
                </div>

                <!-- Total -->
                <div class="px-8 py-10 text-center border-t border-b border-base-200">
                    <span class="text-xs font-semibold tracking-widest text-base-content/50 uppercase">Total
                        Tagihan</span>
                    <h1 class="text-5xl font-bold text-primary mt-3 tracking-tighter">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </h1>
                </div>


                <div class="p-8 space-y-2">
                    <button id="pay-button"
                        class="btn btn-primary btn-block h-14 rounded-2xl text-lg font-semibold shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all duration-300 active:scale-[0.97]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Bayar Sekarang
                    </button>

                    <a href="{{ route('orders.index') }}"
                        class="btn btn-ghost btn-block rounded-2xl text-base-content/60">
                        Bayar nanti, lihat pesanan saya
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script>
        document.getElementById('pay-button').addEventListener('click', function() {

            snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result) {
                    window.location.href = '/payment/success/{{ $order->id_order }}';
                },
                onPending: function(result) {
                    window.location.href = '/payment/pending/{{ $order->id_order }}';
                },
                onError: function(result) {
                    window.location.href = '/payment/failed/{{ $order->id_order }}';
                }
            });

        });
    </script>
</x-app-layout>
