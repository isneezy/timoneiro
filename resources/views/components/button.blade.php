@php
    $variant = $variant ?? 'primary';
    $color = $color ?? 'white';
    $type = $type ?? 'submit';
    $class = $class ?? '';
@endphp
<button
    class="
        inline-block overflow-hidden select-none text-{{ $color }} bg-{{ $variant }} border border-{{ $variant }} font-semibold px-5 py-2 rounded-sm
        {{ $class }}
    "
    type="{{ $type }}"
>
    {{ $slot }}
</button>
