{{-- resources/views/components/dropdown.blade.php --}}
@props([
    'align' => 'right',
    'width' => '48',
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'left-0',
        'top' => 'top-0',
        default => 'right-0',
    };

    $widthClass = match ($width) {
        '48' => 'w-48',
        '56' => 'w-56',
        default => 'w-48',
    };
@endphp

<div class="relative" x-data="{ open: false }">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-cloak x-show="open" @click.outside="open = false"
        class="absolute z-50 mt-2 {{ $widthClass }} {{ $alignmentClasses }}">
        <div class="rounded-xl bg-base-100 shadow-xl ring-1 ring-base-300 p-2">
            {{ $content }}
        </div>
    </div>
</div>
