@props(['name', 'show' => false, 'maxWidth' => '2xl', 'focusable' => false])

<div x-data="{ show: @js($show) }" x-listen:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-listen:close.window="show = false"
    x-listen:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null" x-show="show"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <!-- Backdrop -->
    <div x-show="show" x-on:click="show = false" class="fixed inset-0 bg-black/50 transition-opacity"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="show" x-trap.noscroll.inert="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="bg-base-100 rounded-2xl shadow-xl w-full max-w-{{ $maxWidth }} z-10"
            @click.outside="show = false">
            {{ $slot }}
        </div>
    </div>
</div>
