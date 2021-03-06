<?php

namespace Isneezy\Timoneiro\Http\Middleware;

use Illuminate\Foundation\Application;
use Isneezy\Timoneiro\DataType\AbstractDataType;
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

    public function handle($request, $next, $slug)
    {
        $request = Request::createFrom($request);
        $this->app->call([$request, 'setContainer']);
        $this->app->call([$request, 'setRedirector']);
        $request->attachDataType(Timoneiro::dataType($slug));

        $this->app->instance(Request::class, $request);
        $this->app->instance(AbstractDataType::class, Timoneiro::dataType($slug));

        return $next($request);
    }
}
