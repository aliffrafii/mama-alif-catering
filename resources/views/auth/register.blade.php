<x-guest-layout>
    <div class="space-y-5">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-base-content">Buat Akun</h2>
            <p class="text-sm opacity-70">Daftar untuk mulai memesan</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-semibold text-base-content">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    placeholder="Nama lengkap"
                    class="w-full rounded-xl border border-base-300 bg-base-100 px-3 py-3
                           outline-none focus:ring-4 focus:ring-[#B08A62]/20 focus:border-[#B08A62]
                           transition" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-base-content">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="you@example.com"
                    class="w-full rounded-xl border border-base-300 bg-base-100 px-3 py-3
                           outline-none focus:ring-4 focus:ring-[#B08A62]/20 focus:border-[#B08A62]
                           transition" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-base-content">Password</label>
                <input type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                    class="w-full rounded-xl border border-base-300 bg-base-100 px-3 py-3
                           outline-none focus:ring-4 focus:ring-[#B08A62]/20 focus:border-[#B08A62]
                           transition" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-base-content">Confirm Password</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full rounded-xl border border-base-300 bg-base-100 px-3 py-3
                           outline-none focus:ring-4 focus:ring-[#B08A62]/20 focus:border-[#B08A62]
                           transition" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-[#6B7B3B] px-4 py-3 font-semibold text-white
                       shadow-md hover:bg-[#5A6932] active:bg-[#4E5C2C] transition">
                Register
            </button>

            <a href="{{ route('login') }}"
                class="block w-full text-center rounded-xl border border-base-300 bg-base-100 px-4 py-3
                       font-semibold text-base-content hover:bg-base-200 transition">
                Sudah punya akun? Login
            </a>
        </form>
    </div>
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
