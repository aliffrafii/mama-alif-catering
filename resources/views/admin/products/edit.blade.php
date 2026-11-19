<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="opacity-40 hover:opacity-100 transition">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M5 12l7-7M5 12l7 7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-base-content">Edit Produk</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data"
                class="space-y-4">
                @method('PUT')
                @csrf

                {{-- Info produk saat ini --}}
                <div class="rounded-2xl bg-base-100 shadow p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-widest opacity-40">Edit Produk</p>
                        <span
                            class="text-xs px-2 py-1 rounded-full {{ $product->is_active ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }} font-semibold">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    @include('admin.products._form')
                </div>

                {{-- Aksi --}}
                <div class="flex gap-3">
                    <a href="{{ route('admin.products.index') }}" class="flex-1 btn btn-outline rounded-xl">← Batal</a>
                    <button type="submit"
                        class="flex-1 btn bg-[#6B7B3B] hover:bg-[#5A6932] text-white border-none rounded-xl">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
