{{-- resources/views/components/nav-link.blade.php --}}
@props(['active' => false])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold bg-base-200 text-base-content'
            : 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium text-base-content/80 hover:bg-base-200 hover:text-base-content transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
