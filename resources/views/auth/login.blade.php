<x-guest-layout>
    <div>
        <h2 class="text-2xl font-black tracking-tight text-base-content">Login</h2>
        <p class="text-sm opacity-70">Masuk untuk melanjutkan</p>
    </div>

    <x-auth-session-status class="mt-1" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div class="space-y-2">
            <label class="text-sm font-semibold text-base-content">Email</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 opacity-60">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="2" />
                        <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="2" />
                    </svg>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="you@example.com"
                    class="w-full rounded-xl border border-base-300 bg-base-100 pl-11 pr-3 py-3
                           outline-none focus:ring-4 focus:ring-[#B08A62]/20 focus:border-[#B08A62] transition" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        {{-- Password --}}
        <div class="space-y-2">
            <label class="text-sm font-semibold text-base-content">Password</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 opacity-60">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2" />
                        <path d="M6 11h12v10H6V11Z" stroke="currentColor" stroke-width="2" />
                    </svg>
                </span>
                <input type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                    class="w-full rounded-xl border border-base-300 bg-base-100 pl-11 pr-3 py-3
                           outline-none focus:ring-4 focus:ring-[#B08A62]/20 focus:border-[#B08A62] transition" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        {{-- Remember me + Lupa password --}}
        <div class="flex items-center justify-between pt-1">
            <label class="inline-flex items-center gap-2 text-sm">

            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-[#6B7B3B] hover:underline" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        {{-- Tombol Submit --}}
        <button type="submit"
            class="w-full rounded-xl bg-[#6B7B3B] px-4 py-3 font-semibold text-white
                   shadow-md hover:bg-[#5A6932] active:bg-[#4E5C2C] transition">
            Login
        </button>

        {{-- Divider --}}
        <div class="relative py-2">
            <div class="h-px bg-base-300"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="bg-base-100 px-3 text-sm opacity-70">atau</span>
            </div>
        </div>

        {{-- Link Register --}}
        <a href="{{ route('register') }}"
            class="block w-full text-center rounded-xl border border-base-300 bg-base-100 px-4 py-3
                   font-semibold text-base-content hover:bg-base-200 transition">
            Buat akun baru
        </a>
    </form>
</x-guest-layout>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#login-overlay input, #login-overlay textarea').forEach(field => {
            field.addEventListener('invalid', function() {
                if (this.validity.valueMissing) {
                    this.setCustomValidity('Kolom ini wajib diisi.');
                } else if (this.validity.typeMismatch && this.type === 'email') {
                    this.setCustomValidity('Masukkan format email yang benar.');
                } else if (this.validity.tooShort) {
                    this.setCustomValidity(`Minimal ${this.minLength} karakter.`);
                } else if (this.validity.patternMismatch) {
                    this.setCustomValidity('Format yang dimasukkan tidak sesuai.');
                } else {
                    this.setCustomValidity('');
                }
            });
            field.addEventListener('input', function() {
                this.setCustomValidity(''); // reset validasi saat user mulai mengetik ulang
            });
        });
    });
</script>
