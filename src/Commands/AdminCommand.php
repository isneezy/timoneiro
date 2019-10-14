<?php

namespace Isneezy\Timoneiro\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Isneezy\Timoneiro\Facades\Timoneiro;
use Isneezy\Timoneiro\Models\Role;
use Symfony\Component\Console\Input\InputOption;

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
        Timoneiro::permissions();
        $user = $this->getUser($this->option('create'));

        // no user returned
        if (!$user) {
            exit;
        }

        $role = $this->getAdminRole();
        // get all permissions
        $permissions = Timoneiro::permissions();

        // assign all permissions to admin role
        $role->permissions = $permissions;
        $role->save();

        $user->role_id = $role->id;
        $user->save();
    }

    protected function getAdminRole() {
        $role = Role::where(['name' => 'admin'])->firstOrNew([]);
        if (!$role->exists) {
            $role->forceFill([
                'name' => 'admin',
                'display_name' => 'Administrator'
            ])->save();
        }
        return $role;
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
