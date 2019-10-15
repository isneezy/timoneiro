<form-select class="choices w-full" name="{{ $field->name }}[]" multiple placeholder="{{ $field->placeholder }}">
    @foreach($field->options ?? [] as $option)
        @php
            $selected = in_array($option['value'], $data->{$field->name} ?? [])
        @endphp
        <option @if($selected) selected @endif value="{{ $option['value'] }}">{{ $option['label'] }}</option>
    @endforeach
</form-select>