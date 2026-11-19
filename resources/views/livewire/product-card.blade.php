<div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden group">
    <div class="bg-gradient-to-br from-orange-400 to-red-400 h-40 flex items-center justify-center overflow-hidden">
        @if ($product['image'] ?? null)
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                class="w-full h-full object-cover group-hover:scale-110 transition">
        @else
            <i class="fas fa-image text-white text-4xl opacity-50"></i>
        @endif
    </div>
    <div class="p-4">
        <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $product['name'] }}</h3>
        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product['description'] }}</p>
        <div class="flex justify-between items-center">
            <span class="text-lg font-bold text-orange-500">Rp
                {{ number_format($product['price'], 0, ',', '.') }}</span>
            <a href="{{ route('products.show', $product['id']) }}"
                class="bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-600 transition text-sm">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
</div>
