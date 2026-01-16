<?php

namespace Modules\User\Providers;

use App\Utils\Traits\RegistersConfig;
use App\Utils\Traits\RegistersMigrations;
use App\Utils\Traits\RegistersTranslation;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Modules\User\Application\Contracts\UserInterface;
use Modules\User\Application\Services\UserService;
use Modules\User\Domain\Models\PersonalAccessToken;
use Nwidart\Modules\Traits\PathNamespace;

class UserServiceProvider extends ServiceProvider
{
    use PathNamespace, RegistersMigrations, RegistersConfig, RegistersTranslation;

    protected string $name = 'User';

    protected string $nameLower = 'user';

    protected array $interfaceBinding = [
        UserInterface::class => UserService::class
    ];

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerMigrations();

        $this->customMapping();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);

        $this->registerInterfaceBindings();
    }

    /**
     * Custom mapping for Sanctum Personal Access Token.
     */
    protected function customMapping(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function registerInterfaceBindings(): void
    {
        collect($this->interfaceBinding)->each(function ($implementation, $interface) {
            $this->app->bind($interface, $implementation);
        });
    }
}
