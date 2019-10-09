@php
    $edit = !is_null($data->getKey());
    $add = !is_null($data->getKey());
@endphp

@extends('timoneiro::master')

@section('title', ($edit ? 'Edit' : 'Add').' '.$dataType->display_name_singular)
@section('page_title', ($edit ? 'Edit' : 'Add').' '.$dataType->display_name_singular)

@section('submit-buttons')
    @component('timoneiro::components.button')
        @slot('variant', 'success')
        Save
    @endcomponent
    @component('timoneiro::components.button')
        @slot('variant', 'white')
        @slot('type', 'reset')
        @slot('color', '')
        Reset
    @endcomponent
@endsection

@section('page_content')
    <form
            action="{{ route("timoneiro.$dataType->slug.". ($edit ? 'update' : 'store' ), $data->getKey()) }}"
            method="post"
            enctype="multipart/form-data"
    >
    @if($edit)
        {{ method_field('PUT') }}
    @endif
    <!-- CSRF TOKEN -->
        {{ csrf_field() }}

        <div class="bg-white rounded p-5">
            {{--<h4 class="text-base text-dark font-bold mb-2">Input Types</h4>--}}
            {{--<p class="mb-6">Most common form control, text-based input fields. Includes support for all HTML5 types: text, password...</p>--}}

            @php
                $fieldSet = $dataType->field_set;
            @endphp

            <div class="flex flex-wrap -mx-2">
                @foreach($fieldSet as $field)
                    <div class="px-2 {{ $field->class ?? "w-full" }}">
                        <div class="mb-6">
                            <label class="block">
                                <div class="font-bold block mb-2 cursor-pointer">{{ $field->display_name }}</div>
                                {!! Timoneiro::formField($field, $dataType, $data) !!}
                                @if($errors->has($field->name))
                                    <p class="text-danger mt-1">{{ $errors->first($field->name) }}</p>
                                @endif
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="w-full">
                @yield('submit-buttons')
            </div>
        </div>

    </form>
@endsection
