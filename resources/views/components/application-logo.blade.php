{{-- resources/views/components/application-logo.blade.php --}}
@props([
    'class' => 'h-12 w-12',
    'src' => asset('brand/logo.png'),
    'alt' => 'Catering Mama Alif',
])

<img {{ $attributes->merge(['class' => $class . ' rounded-full object-cover shadow']) }} src="{{ $src }}"
    alt="{{ $alt }}" loading="lazy" />
