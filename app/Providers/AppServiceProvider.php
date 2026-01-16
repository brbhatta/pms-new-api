<?php

namespace App\Providers;

use App\Framework\CommandBus;
use App\Framework\QueryBus;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::defaultMorphKeyType('uuid');

        $this->app->bind('command.bus', CommandBus::class);
        $this->app->bind('query.bus', QueryBus::class);
    }
}
