<?php

namespace Isneezy\Timoneiro;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Isneezy\Timoneiro\Commands\AdminCommand;
use Isneezy\Timoneiro\Commands\InstallCommand;
use Isneezy\Timoneiro\Facades\Timoneiro as TimoneiroFacade;
use Isneezy\Timoneiro\Http\Middleware\TimoneiroAdminMiddleware;
use Isneezy\Timoneiro\Http\Middleware\TimoneiroDataTypeMiddleware;
use Isneezy\Timoneiro\Models\User;
use Isneezy\Timoneiro\Policies\BasePolicy;

class TimoneiroServiceProvider extends ServiceProvider
{
    protected $policies = [];

    protected $gates = [
        'browse_admin',
        'browse_media',
        'browse_settings'
    ];

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
            $this->registerConsoleCommands();
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
        $router->aliasMiddleware('timoneiro', TimoneiroDataTypeMiddleware::class);
        $this->loadMigrationsFrom(realpath(__DIR__.'/../migrations'));

        $this->loadAuth();
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

    public function loadAuth() {
        // DataType Policies
        foreach (TimoneiroFacade::dataTypes() as $dataType) {
            $policyClass = BasePolicy::class;
            if ($dataType->policy_name && $dataType->policy_name != '' && class_exists($dataType->policy_name)) {
                $policyClass = $dataType->policy_name;
            }
            $this->policies[$dataType->model_name] = $policyClass;
        }
        $this->registerPolicies();

        // Gates
        foreach ($this->gates as $gate) {
            Gate::define($gate, function (User $user) use ($gate) {
               return $user->hasPermission($gate);
            });
        }
    }

    public function registerFormFields()
    {
        $formFields = ['date', 'number', 'select_dropdown', 'select_multiple', 'text', 'text_area'];

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

    private function registerConsoleCommands()
    {
        $this->commands(InstallCommand::class);
        $this->commands(AdminCommand::class);
    }
}
