<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content">Kelola Produk</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="alert bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl p-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter & Tambah --}}
            <div class="bg-base-100 rounded-2xl shadow-sm border border-base-200 p-4">
                <div class="flex flex-col md:flex-row gap-4 items-end justify-between">
                    <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                        <div class="w-full md:w-48">
                            <label class="block text-sm font-medium text-base-content mb-2">Kategori</label>
                            <select name="category_id" onchange="this.form.submit()"
                                class="w-full rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-[#6B7B3B] focus:outline-none">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $id => $label)
                                    <option value="{{ $id }}" @selected(request('category_id') == $id)>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-40">
                            <label class="block text-sm font-medium text-base-content mb-2">Status</label>
                            <select name="is_active" onchange="this.form.submit()"
                                class="w-full rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-[#6B7B3B] focus:outline-none">
                                <option value="">Semua</option>
                                <option value="1" @selected(request('is_active') === '1')>Aktif</option>
                                <option value="0" @selected(request('is_active') === '0')>Nonaktif</option>
                            </select>
                        </div>
                    </form>
                    <a href="{{ route('admin.products.create') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#6B7B3B] hover:bg-[#5A6932] text-white text-sm font-semibold px-5 py-3 transition">
                        + Tambah Produk
                    </a>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">{{ $products->total() }} produk ditemukan</p>
            </div>

            <div class="rounded-2xl bg-base-100 shadow overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        {{-- Thumbnail --}}
                                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-base-200 flex-shrink-0">
                                            @if ($product->image)
                                                <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                                    alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-lg">
                                                    {{ match ($product->category_id) {1 => '🍱',2 => '🍛',3 => '🎋',default => '🍽️'} }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm">{{ $product->name }}</p>
                                            @if ($product->description)
                                                <p class="text-xs opacity-40 truncate max-w-[200px]">
                                                    {{ $product->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm">{{ $categories[$product->category_id] ?? '-' }}</td>
                                <td class="text-sm font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="text-sm">{{ $product->stock }}</td>
                                <td>
                                    @if ($product->is_active)
                                        <span
                                            class="text-xs font-semibold px-2 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">Aktif</span>
                                    @else
                                        <span
                                            class="text-xs font-semibold px-2 py-1 rounded-full bg-red-50 text-red-700 border border-red-200">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-right space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-blue-500 hover:underline text-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                        class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:underline text-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 opacity-40 text-sm">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
