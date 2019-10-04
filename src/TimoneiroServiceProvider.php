<?php

namespace Isneezy\Timoneiro;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Isneezy\Timoneiro\Facades\Timoneiro as TimoneiroFacade;
use Isneezy\Timoneiro\Http\Middleware\TimoneiroAdminMiddleware;

class TimoneiroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Timoneiro', TimoneiroFacade::class);

        $this->app->singleton('timoneiro', function () {
            return new Timoneiro();
        });

        $this->loadHelpers();
        $this->registerFormFields();

        $this->registerConfigs();

        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadViewsFrom(realpath(__DIR__.'/../resources/views'), 'timoneiro');
        $router->aliasMiddleware('admin.user', TimoneiroAdminMiddleware::class);
        $this->loadMigrationsFrom(realpath(__DIR__.'/../migrations'));
    }

    public function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    public function registerConfigs()
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/publishable/config/timoneiro.php', 'timoneiro');
    }

    public function registerFormFields()
    {
        $formFields = ['date', 'number', 'select_dropdown', 'text'];

        foreach ($formFields as $formField) {
            $class = Str::studly("{$formField}_handler");
            TimoneiroFacade::addFormField("\\Isneezy\\Timoneiro\\FormFields\\{$class}");
        }
    }

    public function registerPublishableResources()
    {
        $path = sprintf('%s/publishable', dirname(__DIR__));
        $publishable = [
            'timoneiro-config' => [
                "{$path}/config/timoneiro.php" => config_path('timoneiro.php'),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }
}
