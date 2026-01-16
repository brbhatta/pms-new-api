<?php

namespace App\Utils\Traits;

trait RegistersMigrations
{
    public function registerMigrations(): void
    {
        $this->loadMigrationsFrom(
            module_path($this->name, 'database/migrations')
        );
    }
}
