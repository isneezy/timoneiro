<?php

namespace Isneezy\Timoneiro\Commands;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Isneezy\Timoneiro\TimoneiroServiceProvider;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    protected $name = "timoneiro:install";

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run in production', null]
        ];
    }

    /**
     * @param Filesystem $filesystem
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(Filesystem $filesystem)
    {
        $this->info('Migrating database tables into your application');
        $this->call('migrate', ['--force' => $this->option('force')]);

        $this->dumpAutoload();
        $this->registerRoutes($filesystem);

        $this->info('Successfully installed Timoneiro! Enjoy');
    }

    /**
     * @param Filesystem $filesystem
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

    private function dumpAutoload() {
        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process(["{$composer} dump-autoload"]);
        $process->setTimeout(null);
        $process->setWorkingDirectory(base_path())->run();
    }

    private function findComposer() {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'./composer.phar';
        }
        return 'composer';
    }
}