<?php

namespace Modules\User\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Modules\User\Application\Console\CreateUserCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function(){
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('sanctum:prune-expired --hours=24')->daily();
        });
    }

    public function register(): void
    {
        $this->commands(...$this->getCommands());
    }

    private function getCommands(): array
    {
        return [
            CreateUserCommand::class,
        ];
    }
}
