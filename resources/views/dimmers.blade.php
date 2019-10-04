@php
    $dimmers = Timoneiro::dimmers();
    $count = $dimmers->count();
    $grid = $count <= 4 ? $count : 4;
    $classes = [
        "w-1/$count"
    ];
    $prefix = '<div class="'.implode(' ', $classes).' px-2">';
    $suffix = '</div>';
@endphp
<div class="flex -mx-2">
    {!! $prefix.$dimmers->setSeparator($suffix.$prefix)->display().$suffix !!}
</div>
