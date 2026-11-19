{{-- resources/views/components/dropdown-link.blade.php --}}
@props(['href' => '#'])

<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'block px-3 py-2 rounded-lg text-sm hover:bg-base-200 transition']) }}>
    {{ $slot }}
</a>
