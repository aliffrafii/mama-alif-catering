{{-- resources/views/components/auth-session-status.blade.php --}}
@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success shadow mt-2']) }}>
        <span>{{ $status }}</span>
    </div>
@endif
