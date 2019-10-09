<input
    type="text"
    name="{{ $field->name }}"
    class="block w-full py-2 px-3 font-semibold text-dark bg-white rounded border focus:border-gray-500"
    placeholder="{{ $field->placeholder }}"
    value="{{ old($field->name, $data->{$field->name}) ?? $field->default }}"
>
