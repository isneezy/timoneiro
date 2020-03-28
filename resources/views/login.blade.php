<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Admin - {{ config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ timoneiro_assets('css/style.css') }}">
    @include('timoneiro::theme')
</head>
<body class="bg-white flex">
<div class="w-4/6 min-h-screen bg-no-repeat bg-cover" style='background-image: url("{{ timoneiro_assets('images/bg.jpg') }}")'></div>
<div class="flex-1 mx-2 flex items-center">
    <div class="w-full">
        <form class="px-8 pt-6 pb-8 mb-4" action="{{ route('timoneiro.login') }}"
              method="post">
            {{ csrf_field() }}

            <h1 class="flex justify-center mb-8">
                <a href="{{ route('timoneiro.dashboard') }}">
                    @php
                        $logoUrl = Timoneiro::setting('logo', timoneiro_assets('images/logo.svg'))
                    @endphp
                    <img class="text-center" src="{{ $logoUrl }}" alt="{{ config('app.name')  }}">
                </a>
            </h1>
            <p class="text-center text-gray-500 text-sm mb-8">Enter your email address and password to access admin panel.</p>

            <div class="mb-4">
                <label class="block text-secondary text-sm font-bold mb-2" for="username">
                    Enter your email
                </label>
                <input
                        class="@if($errors->has('email')) border-danger @endif block w-full py-2 px-3 text-sm text-dark bg-white rounded border focus:border-gray-500"
                        id="username" name="email"
                        type="text"
                        placeholder="example@email.com"
                        value="{{ old('email') }}"
                />
                @if($errors->has('email'))
                    <p class="text-red-500 text-xs italic mt-3">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="mb-6">
                <label class="block text-secondary text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                        class="@if($errors->has('password')) border-danger @endif  block w-full py-2 px-3 text-sm text-dark bg-white rounded border focus:border-gray-500"
                        id="password" name="password"
                        type="password"
                        placeholder="******************"
                />
                @if($errors->has('password'))
                    <p class="text-red-500 text-xs italic mt-3">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <button
                    class="w-full bg-primary text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                Sign In
            </button>
        </form>
        <p class="text-center text-gray-500 text-xs mb-10">
            <a class="inline-block align-baseline text-sm hover:text-primary" href="#">
                Forgot Password?
            </a>
        </p>
    </div>
</div>
</body>
</html>
