<?php

use Illuminate\Support\Str;
use Isneezy\Timoneiro\DataType\DataType;
use Isneezy\Timoneiro\Facades\Timoneiro;

if (!function_exists('str_start')) {
    function str_start($string, $start)
    {
        return Str::startsWith($string, '/') ? $string : "$start$string";
    }
}

if (!function_exists('timoneiro_menu')) {
    function timoneiro_menu()
    {
        $dataTypes = Timoneiro::dataTypes();
        $menu = [];
        foreach ($dataTypes as $key => $dataType) {
            /* @var $dataType DataType */
            $menuItem['label'] = $dataType->display_name_plural;
            $menuItem['icon-class'] = $dataType->icon_class;
            $menuItem['slug'] = $dataType->slug;
            $menuItem['active'] = request()->routeIs('timoneiro.'.$dataType->slug.'*');
            $menu[] = $menuItem;
        }

        return $menu;
    }
}

if (!function_exists('value_fallback')) {
    /**
     * Returns the $value if not falsy, $default or result of $default
     * if $default is instance of Closure.
     *
     * @param mixed           $value
     * @param Closure | mixed $default
     *
     * @return mixed
     */
    function value_fallback($value, $default)
    {
        if (is_null($value)) {
            if ($default instanceof Closure) {
                $value = $default();
            } else {
                $value = $default;
            }
        }

        return $value;
    }
}

if (!function_exists('starts_with')) {
    /**
     * @param $string
     * @param $needle string | array
     *
     * @return bool
     */
    function starts_with($string, $needle)
    {
        return Str::startsWith($string, $needle);
    }
}

if (!function_exists('timoneiro_assets')) {
    function timoneiro_assets($name, $secure = null)
    {
        $name = str_start($name, '/');
        $basePath = '/publishable/assets';
        $manifest = json_decode(file_get_contents(__DIR__.'/../../mix-manifest.json'), true);
        $compiled = \Illuminate\Support\Arr::get($manifest, "{$basePath}{$name}", "");
        $version = substr($compiled, strpos($compiled,'id=') + 3);
        $route = route('timoneiro.assets').'?path='.urlencode($name);
        if ($version) {
            $route = $route."&version=$version";
        }
        return $route;
    }
}

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Timoneiro::setting($key, $default);
    }
}
