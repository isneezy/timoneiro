<?php

namespace Isneezy\Timoneiro\Http\Middleware;


use Illuminate\Foundation\Application;
use Isneezy\Timoneiro\Facades\Timoneiro;
use Isneezy\Timoneiro\Http\Request;

class TimoneiroDataTypeMiddleware
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, $next, $slug) {
        $request = Request::createFrom($request);
        $request->attachDataType(Timoneiro::dataType($slug));

        $this->app->instance(Request::class, $request);
        return $next($request);
    }
}