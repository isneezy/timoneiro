<?php

namespace Isneezy\Timoneiro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use isneezy\timoneiro\Timoneiro;

class TimoneiroController extends Controller
{

    public function index()
    {
        return Timoneiro::view('timoneiro::index');
    }

    public function assets(Request $request)
    {
        $path = str_start(str_replace(['../', './'], '', urldecode($request->path)), '/');
        $path = base_path("packages/laradzosa/publishable/assets$path");
        if (File::exists($path)) {
            if (Str::endsWith($path, '.js')) {
                $mime = 'text/javascript';
            } elseif (Str::endsWith($path, '.css')) {
                $mime = 'text/css';
            }
            else {
                $mime = File::mimeType($path);
            }

            $response = response(File::get($path), 200, ['Content-Type' => $mime]);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));

            return $response;
        }

        return response('', 404);
    }
}
