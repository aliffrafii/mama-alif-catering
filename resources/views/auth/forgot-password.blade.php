<x-guest-layout>
    <div class="space-y-5">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-base-content">Lupa Password</h2>
            <p class="text-sm opacity-70">
                Masukkan email akun Anda. Kami akan mengirim tautan untuk mengatur ulang password.
            </p>
        </div>

        <x-auth-session-status class="mt-1" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-semibold text-base-content">Email</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 opacity-60">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="2" />
                            <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username" placeholder="you@example.com"
                        class="w-full rounded-xl border border-base-300 bg-base-100 pl-11 pr-3 py-3
                               outline-none focus:ring-4 focus:ring-[#B08A62]/20 focus:border-[#B08A62]
                               transition" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-[#6B7B3B] px-4 py-3 font-semibold text-white
                       shadow-md hover:bg-[#5A6932] active:bg-[#4E5C2C] transition">
                Kirim Tautan Reset Password
            </button>

            <a href="{{ route('login') }}"
                class="block w-full text-center rounded-xl border border-base-300 bg-base-100 px-4 py-3
                       font-semibold text-base-content hover:bg-base-200 transition">
                Kembali ke Login
            </a>
        </form>
    </div>
</x-guest-layout>
