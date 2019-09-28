<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>{{ config('app.name') }} - @yield('title', 'Site admin task made so easy.')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="assets-path" content="{{ route('timoneiro.assets') }}"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,600" rel="stylesheet">

    <!-- Material design Icons -->
    <link href="https://cdn.materialdesignicons.com/1.1.34/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- App css -->
    <link rel="stylesheet" href="{{ timoneiro_assets('css/style.css') }}">

    @include('timoneiro::theme')
</head>
<body class="font-body font-normal text-sm leading-normal text-secondary bg-light">
<!-- Begin Page -->
<div id="app" class="h-full overflow-hidden w-full">
    @include('timoneiro::dashboard.nav-bar')
    <div class="h-screen pt-16 flex">
        @include('timoneiro::dashboard.sidebar')
        <div class="overflow-auto px-4 flex-1">
            <div class="container w-full px-2">
                <div class="flex -mx-2">
                    <div class="w-full px-2 flex items-center">
                        <h4 class="flex-1 text-2xl font-bold text-dark my-6">@yield('page_title')</h4>
                        <div>
                            <!-- Todo page tools -->
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    @yield('page_content')
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ timoneiro_assets('/js/app.js') }}" type="text/javascript"></script>
</body>
</html>
