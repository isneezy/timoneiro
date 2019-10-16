<?php

namespace Isneezy\Timoneiro\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Isneezy\Timoneiro\TimoneiroServiceProvider;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    protected $name = 'timoneiro:install';

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run in production', null],
        ];
    }

    /**
     * @param Filesystem $filesystem
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(Filesystem $filesystem)
    {
        $this->info('Publishing the Timoneiro assets, database, and config files');
        // publish only relevant resources on install
        $tags = ['config'];
        $this->call('vendor:publish', ['--provider' => TimoneiroServiceProvider::class, '--tag' => $tags]);

        $this->info('Migrating database tables into your application');
        $this->call('migrate', ['--force' => $this->option('force')]);

        $this->extendUserModel();

        $this->dumpAutoload();
        $this->registerRoutes($filesystem);

        $this->info('Successfully installed Timoneiro! Enjoy');
    }

    /**
     * @param Filesystem $filesystem
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function registerRoutes(Filesystem $filesystem)
    {
        $this->info('Adding Timoneiro routes to routes/web.php');
        $content = $filesystem->get(base_path('routes/web.php'));
        if (false === strpos($content, 'Timoneiro::routes()')) {
            $filesystem->append(
                base_path('routes/web.php'),
                "\n\nRoute::group(['prefix' => 'admin'], function() {\n    Timoneiro::routes();\n});\n"
            );
        }
    }

    protected function extendUserModel()
    {
        $userModel = config('auth.providers.users.model');
        $this->info("Attempting to set Timoneiro User Model as parent to $userModel");

        try {
            $path = (new \ReflectionClass($userModel))->getFileName();
            $str = file_get_contents($path);
            $str = str_replace('extends Authenticatable', "extends \Isneezy\Timoneiro\Models\User", $str);

            file_put_contents($path, $str);
        } catch (\Exception $e) {
            $this->warn("Unable to set Timoneiro User Model as parent to $userModel");
            $this->warn('You will need to update this manually.  Change "extends Authenticatable" to "extends \Isneezy\Timoneiro\Models\User" in your User model');
        }
    }

    private function dumpAutoload()
    {
        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process(["{$composer} dump-autoload"]);
        $process->setTimeout(null);
        $process->setWorkingDirectory(base_path())->run();
    }

    private function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'./composer.phar';
        }

        return 'composer';
    }
}
