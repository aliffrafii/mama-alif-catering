<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.index') }}" class="opacity-40 hover:opacity-100 transition">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M5 12l7-7M5 12l7 7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-base-content">Edit Pelanggan</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.customers.update', $user) }}" class="space-y-4">
                @csrf @method('PATCH')

                <div class="rounded-2xl bg-base-100 shadow p-6 space-y-4">
                    <p class="text-xs font-bold uppercase tracking-widest opacity-40">Edit Data Pelanggan</p>

                    <div class="form-control">
                        <label class="block text-sm font-medium text-base-content mb-1">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="input input-bordered w-full" required />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="block text-sm font-medium text-base-content mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="input input-bordered w-full" required />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.customers.index') }}" class="flex-1 btn btn-outline rounded-xl">← Batal</a>
                    <button type="submit"
                        class="flex-1 btn bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-xl">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
