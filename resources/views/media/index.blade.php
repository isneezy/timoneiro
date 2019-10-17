@extends('timoneiro::master')

@section('title', 'Media')
@section('page_title')
    <i class="mdi mdi-folder-multiple-image"></i>
    <span>Media</span>
@endsection

@section('page_content')
    <media-manager
        base-path="{{ route('timoneiro.media.index') }}"
        :allow-upload="true"
        :allow-create-folder="true"
        :allow-move="true"
        :allow-rename="true"
        :allow-delete="true"
        :mime-types="{{ json_encode(config('timoneiro.media.mime_types')) }}"
    ></media-manager>
@endsection