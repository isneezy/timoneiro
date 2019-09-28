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
<body class="bg-light">
<div class="flex h-screen justify-center items-center">
    <div class="w-full max-w-xs mx-2">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('timoneiro.login') }}"
              method="post">
            {{ csrf_field() }}
            <div class="mb-4">
                <label class="block text-secondary text-sm font-bold mb-2" for="username">
                    Email
                </label>
                <input
                    class="shadow appearance-none border border-light  @if($errors->has('email')) border-danger @endif rounded w-full py-2 px-3 text-dark leading-tight focus:outline-none focus:shadow-outline"
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
                    class="shadow appearance-none border border-light  @if($errors->has('password')) border-danger @endif rounded w-full py-2 px-3 text-dark leading-tight focus:outline-none focus:shadow-outline"
                    id="password" name="password"
                    type="password"
                    placeholder="******************"
                />
                @if($errors->has('password'))
                    <p class="text-red-500 text-xs italic mt-3">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-info text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Sign In
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-primary hover:text-info" href="#">
                    Forgot Password?
                </a>
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">
            &copy;2019 Acme Corp. All rights reserved.
        </p>
    </div>
</div>
</body>
</html>
