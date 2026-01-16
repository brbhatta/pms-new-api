<?php

namespace Modules\User\Application\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create {name} {email} {password}';
    protected $description = 'Create a new internal user';

    public function handle(): void
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
        ]);

        $this->info('User created: ' . $user->id);
    }
}

