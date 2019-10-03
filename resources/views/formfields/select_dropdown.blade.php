@if($field->relationship)
    {{-- If this is relationship and the method does not exist, show a warning message --}}
    @if(!method_exists($dataType->model_name, \Illuminate\Support\Str::camel($field->relationship['name'])))
        <p class="text-warning">
            <i class="mdi mdi-alert"></i>
            {!!
                sprintf(
                "Make sure to setup the appropriate relationship in the <i class=\"text-danger\">%s</i> method of the <i class=\"text-danger\">%s</i> class.",
                $field->relationship['name'],
                $dataType->model_name
                )
            !!}
        </p>
    @else
        @php
            $selectedValue = old($field->name, $data->{$field->name} ?? $field->default);
        @endphp
    @endif
@endif

<select
    class="w-full py-2 px-3 font-semibold text-dark bg-white rounded border focus:border-gray-500 appearance-none"
    name="{{ $field->name }}">
    @foreach($field->options ?? [] as $option)
        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
    @endforeach
</select>
