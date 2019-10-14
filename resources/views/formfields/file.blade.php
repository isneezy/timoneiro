<file-input
        name="{{ $field->name }}"
        value='["http://localhost:8000/storage/Ivan/Lara.jpg"]'
        wrapper-class="px-3 py-2 border border-dashed cursor-pointer"
        base-path="{{ route('timoneiro.media.index') }}"
>
    <p class="font-semibold py-2" slot="empty">Drop files here or click to upload</p>
</file-input>

