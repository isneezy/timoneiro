<?php

namespace Isneezy\Timoneiro\Http\Middleware;

use Closure;

class TimoneiroAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->guest()) {
            $user = auth()->user();
            app()->setLocale($user->locale ?? app()->getLocale());

            // todo check if the user has permissions to browse admin
            return true ? $next($request) : redirect('/');
        }

        return redirect()->route('timoneiro.login');
    }
}
