<?php
$namespacePrefix = '\\' . config('timoneiro.controllers.namespace') . '\\';

Route::group(['as' => 'timoneiro.', 'namespace' => $namespacePrefix], function () {

    Route::get('login', "AuthController@showLoginForm")->name('login');
    Route::post('login', "AuthController@login")->name('loginPost');

    Route::group(['middleware' => 'admin.user'], function () {
        Route::get('/', 'TimoneiroController@index')->name('dashboard');

        try {
            foreach (Isneezy\Timoneiro\Timoneiro::dataTypes() as $dataType) {
                /** @var $dataType \Isneezy\Timoneiro\DataType */
                $breadController = $dataType->controller;
                $slug = $dataType->slug;

                Route::resource($slug, $breadController);
            }
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException("Custom routes hasn't been configured because: " . $e->getMessage(), 1);
        }
    });

    // Assets Route
    Route::get('timoneiro-assets', 'TimoneiroController@assets')->name('assets');
});
