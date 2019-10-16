@php
    $mimes = json_encode($field->mime_types ?? config('timoneiro.media.mime_types'));
    $value = old($field->name, $data->{$field->name});
    if(is_array($value) || is_object($value)) {
        $value = json_encode($value);
    }
@endphp
<file-input
        name="{{ $field->name }}"
        value='{{ $value }}'
        wrapper-class="px-3 py-2 border border-dashed cursor-pointer"
        base-path="{{ route('timoneiro.media.index') }}"
        :multiple="{{ $field->multiple ? 'true' : 'false' }}"
        :mime-types="{{ $mimes }}"
>
    <p class="font-semibold py-2" slot="empty">No files selected, click here to upload.</p>
</file-input>

