<x-guest-layout>
    <div class="space-y-5">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-base-content">Konfirmasi Password</h2>
            <p class="text-sm opacity-70">
                Demi keamanan, silakan masukkan password Anda untuk melanjutkan.
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-semibold text-base-content">Password</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 opacity-60">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2" />
                            <path d="M6 11h12v10H6V11Z" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>
                    <input type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-base-300 bg-base-100 pl-11 pr-3 py-3
                               outline-none focus:ring-4 focus:ring-[#B08A62]/20 focus:border-[#B08A62]
                               transition" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-[#6B7B3B] px-4 py-3 font-semibold text-white
                       shadow-md hover:bg-[#5A6932] active:bg-[#4E5C2C] transition">
                Konfirmasi
            </button>
        </form>
    </div>
</x-guest-layout>
