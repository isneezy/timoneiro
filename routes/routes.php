<?php

use Illuminate\Support\Facades\Route;
use Isneezy\Timoneiro\DataType\DataType;
use Isneezy\Timoneiro\Facades\Timoneiro;

$namespacePrefix = '\\'.config('timoneiro.controllers.namespace').'\\';

Route::group(['as' => 'timoneiro.', 'namespace' => $namespacePrefix], function () {
    Route::get('login', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('loginPost');
    Route::post('logout', 'AuthController@logout')->name('logout');

    Route::group(['middleware' => 'admin.user'], function () {
        Route::get('/', 'TimoneiroController@index')->name('dashboard');

        try {
            foreach (Timoneiro::dataTypes() as $dataType) {
                /** @var $dataType DataType */
                $breadController = $dataType->controller;
                $slug = $dataType->slug;

                Route::resource($slug, $breadController)->middleware("timoneiro:{$slug}");
            }
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException("Custom routes hasn't been configured because: ".$e->getMessage(), 1);
        }

        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/', 'TimoneiroSettingsController@index')->name('index');
            Route::put('/', 'TimoneiroSettingsController@update')->name('update');
        });

        Route::group(['prefix' => 'media', 'as' => 'media.'], function () {
            Route::get('/', 'TimoneiroMediaController@index')->name('index');
            Route::get('files', 'TimoneiroMediaController@files')->name('files');
            Route::post('new-folder', 'TimoneiroMediaController@newFolder')->name('new-folder');
            Route::post('delete', 'TimoneiroMediaController@delete')->name('delete');
            Route::post('upload', 'TimoneiroMediaController@upload')->name('upload');
            Route::post('rename', 'TimoneiroMediaController@rename')->name('rename');
            Route::post('move', 'TimoneiroMediaController@move')->name('move');
        });
    });
    // Assets Route
    Route::get('timoneiro-assets', 'TimoneiroController@assets')->name('assets');
});
