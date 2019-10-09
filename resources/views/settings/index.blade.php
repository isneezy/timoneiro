@extends('timoneiro::master')

@section('title', 'Settings')
@section('page_title', 'Settings')

@section('page_content')
    <div class="bg-white rounded p-5">
        <h1 class="font-bold text-dark text-base mb-8">Manage Settings</h1>
        @if(empty($settings))
            <div class="flex items-center text-warning">
                <i class="mdi mdi-alert text-xl mr-2"></i>
                <p>Make sure to setup the settings in the <i class="text-danger">config/timoneiro.php</i> file.</p>
            </div>
        @else
            <form action="{{ route('timoneiro.settings.update') }}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <input type="hidden" name="_group" value="{{ $active }}">
                <div class="flex -mx-4">
                    <div class="px-4 w-1/5">
                        @foreach($groups as $group)
                            <a
                                href="{{ request()->fullUrlWithQuery(['group' => $group]) }}"
                                class="{{ $active === $group ? 'text-white bg-primary' : '' }} rounded font-bold mb-3 block py-2 px-4"
                            >
                                {{ $group }}
                            </a>
                        @endforeach
                    </div>
                    <div class="px-4 flex-1">
                        @foreach($settings as $setting)
                            <div class="w-full">
                                <div class="mb-6">
                                    <label class="block">
                                        <div
                                            class="font-bold block mb-2 cursor-pointer">{{ $setting->display_name }}</div>
                                        {!! Timoneiro::formField($setting, null, $data->get($setting->name)) !!}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class=" flex -mx-4">
                    <div class="w-1/5 px-4"></div>
                    <div class="px-4 flex-1">
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
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection

