<div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-l-4 border-{{ $color }}-500">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-600 text-sm font-medium">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-800">{{ $value }}</p>
        </div>
        <i class="{{ $icon }} text-4xl text-{{ $color }}-500 opacity-20"></i>
    </div>
</div>
