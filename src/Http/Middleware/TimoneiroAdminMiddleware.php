<?php

namespace Isneezy\Timoneiro\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Isneezy\Timoneiro\Models\User;

class TimoneiroAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->guest()) {
            /** @var User $user */
            $user = auth()->user();
            app()->setLocale($user->locale ?? app()->getLocale());
            if (!$user->hasPermission('browse_admin')) {
                if ($this->isInstalledOnRoot()) {
                    return abort(403);
                } else {
                    return redirect('/');
                }
            }

            return  $next($request);
        }

        return redirect()->route('timoneiro.login');
    }

    public function isInstalledOnRoot()
    {
        return route('timoneiro.dashboard') === url('/');
    }
}
