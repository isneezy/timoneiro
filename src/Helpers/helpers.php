<?php

use Illuminate\Support\Str;
use Isneezy\Timoneiro\Timoneiro;

if (!function_exists('str_start')) {
    function str_start($string, $start)
    {
        return Str::startsWith($string, '/') ? $string : "$start$string";
    }
}

if (!function_exists('menu')) {
    function menu()
    {
        $dataTypes = Timoneiro::dataTypes();
        $menu = [];
        foreach ($dataTypes as $key => $dataType) {
            /** @var $dataType \Isneezy\Timoneiro\DataType */
            $menuItem['label'] = $dataType->label();
            $menuItem['icon-class'] = $dataType->iconClass();
            $menuItem['link'] = $dataType->routes()['browse'];
            $menuItem['active'] = request()->routeIs('timoneiro.'.$dataType->slug().'*');
            $menu[] = $menuItem;
        }
        return $menu;
    }
}

if (!function_exists('starts_with')) {
    /**
     * @param $string
     * @param $needle string | array
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
        return route('timoneiro.assets') . '?path=' . urlencode($name);
    }
}
