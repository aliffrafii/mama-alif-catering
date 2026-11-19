{{-- resources/views/components/text-input.blade.php --}}
@props(['disabled' => false])

<input
    {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent']) }}>
