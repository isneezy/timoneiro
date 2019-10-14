<?php

namespace Isneezy\Timoneiro\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class AdminCommand extends Command
{
    protected $name = 'timoneiro:admin';

    protected $description = 'Make sure there is  a user  with the admin role that has all of the necessary permissions.';

    protected function getOptions() {
        return [
            ['create', null, InputOption::VALUE_NONE, 'Create an admin user', null]
        ];
    }

    protected function getArguments()
    {
        return [
            ['email', InputOption::VALUE_REQUIRED, 'The email of the user.', null]
        ];
    }

    public function handle() {
        $user = $this->getUser($this->option('create'));

        // no user returned
        if (!$user) {
            exit;
        }

        $user->save();
    }

    protected function getUser($create) {
        $email = $this->argument('email');
        $model = config('auth.providers.users.model');

        if ($create) {
            $name = $this->ask('Enter the admin name');
            $password = $this->secret('Enter admin password');
            $confirmPassword = $this->secret('Confirm password');

            if (!$email) {
                $email = $this->ask('Enter admin email');
            }

            if ($password != $confirmPassword) {
                $this->info('Passwords do not match');
                return null;
            }

            $this->info('Creating admin account');
            $password = Hash::make($password);
            return $model::create(compact('name', 'email', 'password'));
        }

        return $model::where(['email' => $email])->firstOrFail();
    }
}
