<?php
namespace Isneezy\Timoneiro\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use isneezy\timoneiro\Timoneiro;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm() {
        if($this->guard()->user()) {
            return redirect()->route('timoneiro.dashboard');
        }
        return Timoneiro::view('timoneiro::login');
    }

    public function redirectPath()
    {
        return route('timoneiro.dashboard');
    }
}
