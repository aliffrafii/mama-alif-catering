{{-- resources/views/components/auth-validation-errors.blade.php --}}
@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'alert alert-error shadow']) }}>
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
