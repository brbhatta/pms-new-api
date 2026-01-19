<?php

namespace Modules\Organisation\Providers;

use App\Utils\Traits\RegistersConfig;
use App\Utils\Traits\RegistersMigrations;
use App\Utils\Traits\RegistersTranslation;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use Modules\Organisation\Application\Contracts\OrganisationUnitServiceInterface;
use Modules\Organisation\Application\Services\OrganisationUnitService;

class OrganisationServiceProvider extends ServiceProvider
{
    use PathNamespace, RegistersMigrations, RegistersConfig, RegistersTranslation;

    protected string $name = 'Organisation';

    protected string $nameLower = 'organisation';

    protected array $interfaceBinding = [
        OrganisationUnitServiceInterface::class => OrganisationUnitService::class,
    ];

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerMigrations();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        // bind interfaces declared in $interfaceBinding
        foreach ($this->interfaceBinding as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
