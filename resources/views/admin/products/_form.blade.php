@csrf

<div class="space-y-1">
    <label class="text-sm font-semibold">Kategori</label>
    <select name="category_id" id="category_id" class="select select-bordered w-full" required
        onchange="toggleMenuOptions()">
        @foreach ($categories as $id => $label)
            <option value="{{ $id }}" @selected(old('category_id', $product->category_id ?? null) == $id)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

<div class="space-y-1">
    <label class="text-sm font-semibold">Nama Produk</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
        class="input input-bordered w-full" required>
    @error('name')
        <p class="text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

<div class="space-y-1">
    <label class="text-sm font-semibold">Deskripsi</label>
    <textarea name="description" rows="3" class="textarea textarea-bordered w-full">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-3">
    <div class="space-y-1">
        <label class="text-sm font-semibold">Harga (Rp)</label>
        <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
            class="input input-bordered w-full" required>
        @error('price')
            <p class="text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>
    <div class="space-y-1">
        <label class="text-sm font-semibold">Stok</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
            class="input input-bordered w-full" required>
        @error('stock')
            <p class="text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>

@php
    $maxIsianValue = old('max_isian', isset($product) ? ($product->menu_options ?? [])['max_isian'] ?? '' : '');
    $menuItemsValue = old(
        'menu_items',
        isset($product) && !empty(($product->menu_options ?? [])['items'])
            ? implode("\n", $product->menu_options['items'])
            : '',
    );
@endphp

<div id="field-max-isian" class="space-y-1" style="display:none">
    <label class="text-sm font-semibold">Maksimal Pilihan Isian</label>
    <input type="number" name="max_isian" min="0" value="{{ $maxIsianValue }}"
        class="input input-bordered w-full" placeholder="cth: 2">
    <p class="text-xs opacity-50">Khusus Nasi Box — jumlah isian yang boleh dipilih customer.</p>
</div>

<div id="field-menu-items" class="space-y-1" style="display:none">
    <label class="text-sm font-semibold">Daftar Menu Termasuk</label>
    <textarea name="menu_items" rows="6" class="textarea textarea-bordered w-full" placeholder="Satu menu per baris">{{ $menuItemsValue }}</textarea>
    <p class="text-xs opacity-50">Khusus Prasmanan — satu item menu per baris.</p>
</div>

{{-- Gambar --}}
<div class="space-y-2">
    <label class="text-sm font-semibold">Gambar Produk</label>
    @isset($product)
        @if ($product->image)
            <div class="relative w-32 h-32">
                <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                    class="w-32 h-32 object-cover rounded-2xl border border-base-300">
                <label
                    class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-2xl opacity-0 hover:opacity-100 transition cursor-pointer text-white text-xs font-semibold">
                    Ganti Foto
                    <input type="file" name="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                </label>
            </div>
            <p class="text-xs opacity-40">Hover gambar lalu klik untuk mengganti.</p>
        @else
            <div class="w-32 h-32 rounded-2xl bg-base-200 border-2 border-dashed border-base-300 flex flex-col items-center justify-center gap-1 cursor-pointer hover:bg-base-300 transition"
                onclick="document.getElementById('img-upload').click()">
                <svg class="w-8 h-8 opacity-30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M4 16l4-4 4 4 4-6 4 6" stroke-linecap="round" stroke-linejoin="round" />
                    <rect x="3" y="3" width="18" height="18" rx="3" />
                </svg>
                <span class="text-xs opacity-40">Upload foto</span>
            </div>
            <input type="file" name="image" id="img-upload" class="hidden" accept="image/*"
                onchange="previewImage(this)">
        @endif
    @else
        <div class="w-32 h-32 rounded-2xl bg-base-200 border-2 border-dashed border-base-300 flex flex-col items-center justify-center gap-1 cursor-pointer hover:bg-base-300 transition"
            onclick="document.getElementById('img-upload').click()">
            <svg class="w-8 h-8 opacity-30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 16l4-4 4 4 4-6 4 6" stroke-linecap="round" stroke-linejoin="round" />
                <rect x="3" y="3" width="18" height="18" rx="3" />
            </svg>
            <span class="text-xs opacity-40">Upload foto</span>
        </div>
        <input type="file" name="image" id="img-upload" class="hidden" accept="image/*"
            onchange="previewImage(this)">
    @endisset
    <div id="img-preview-wrap" class="hidden">
        <img id="img-preview" class="w-32 h-32 object-cover rounded-2xl border border-base-300">
        <p class="text-xs opacity-40 mt-1">Preview gambar baru</p>
    </div>
</div>

<label class="flex items-center gap-2 cursor-pointer">
    <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-sm"
        @checked(old('is_active', $product->is_active ?? true))>
    <span class="text-sm font-semibold">Aktif (tampil di menu)</span>
</label>

<script>
    function toggleMenuOptions() {
        const cat = document.getElementById('category_id').value;
        document.getElementById('field-max-isian').style.display = (cat === '1') ? 'block' : 'none';
        document.getElementById('field-menu-items').style.display = (cat === '2') ? 'block' : 'none';
    }

    function previewImage(input) {
        const wrap = document.getElementById('img-preview-wrap');
        const preview = document.getElementById('img-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                wrap.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.addEventListener('DOMContentLoaded', toggleMenuOptions);
</script>
