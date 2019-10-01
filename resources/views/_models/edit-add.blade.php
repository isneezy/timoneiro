@php
    $edit = !is_null($data->getKey());
    $add = !is_null($data->getKey());
@endphp

@extends('timoneiro::master')

@section('title', ($edit ? 'Edit' : 'Add').' '.$dataType->display_name_singular)
@section('page_title', ($edit ? 'Edit' : 'Add').' '.$dataType->display_name_singular)

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

            @foreach($fieldSet as $field)
                <div class="-mx-2">
                    <div class="w-full px-2">
                        <div class="mb-6">
                            <label class="block">
                                <div class="font-bold block mb-2 cursor-pointer">{{ $field->display_name }}</div>
                                {!! \Isneezy\Timoneiro\Timoneiro::formField($field, $dataType, $data) !!}
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="w-full px-2">
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
                @yield('submit-buttons')
            </div>
        </div>

    </form>
@endsection
