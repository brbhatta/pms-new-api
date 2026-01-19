<?php

namespace Modules\User\Application\Console;

use Illuminate\Console\Command;
use Modules\User\Application\UseCases\CreateUserAction;
use Modules\User\Http\Data\UserData;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create {name} {email} {password}';
    protected $description = 'Create a new internal user';

    public function __construct(
        private readonly CreateUserAction $action
    ) {
        parent::__construct();
    }

    /**
     * @throws \Throwable
     */
    public function handle(): void
    {
        $userData = UserData::from([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
        ]);

        $user = $this->action->handle($userData);

        $this->info("User {$user->name} with email {$user->email} created successfully.");
    }
}

