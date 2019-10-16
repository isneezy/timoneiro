<form-select class="choices w-full" name="{{ $field->name }}[]" multiple placeholder="{{ $field->placeholder }}">
    @foreach($field->options ?? [] as $group => $option)
        @if(is_array($option))
            <optgroup label="{{ $group }}">
                @foreach($option as $groupOption)
                    @php
                        $selected = in_array($groupOption['value'], $data->{$field->name} ?? [])
                    @endphp
                    <option @if($selected) selected @endif value="{{ $groupOption['value'] }}">{{ $groupOption['label'] }}</option>
                @endforeach
            </optgroup>
        @else
            @php
                $selected = in_array($option['value'], $data->{$field->name} ?? [])
            @endphp
            <option @if($selected) selected @endif value="{{ $option['value'] }}">{{ $option['label'] }}</option>
        @endif
    @endforeach
</form-select>