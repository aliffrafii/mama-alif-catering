<x-guest-layout>
    <div class="space-y-5">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-base-content">Verifikasi Email</h2>
            <p class="text-sm opacity-70">
                Sebelum mulai, silakan verifikasi email Anda melalui tautan yang kami kirimkan.
                Jika belum menerima email, Anda bisa meminta pengiriman ulang.
            </p>
        </div>

        @if (session('status') === 'verification-link-sent')
            <div class="rounded-xl border border-base-300 bg-base-100 p-4 shadow">
                <p class="text-sm font-semibold text-[#6B7B3B]">
                    Tautan verifikasi baru sudah dikirim ke email Anda.
                </p>
            </div>
        @endif

        <div class="flex flex-col gap-2 sm:flex-row">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full rounded-xl bg-[#6B7B3B] px-4 py-3 font-semibold text-white
                           shadow-md hover:bg-[#5A6932] active:bg-[#4E5C2C] transition">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full rounded-xl border border-base-300 bg-base-100 px-4 py-3 font-semibold
                           text-base-content hover:bg-base-200 transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
