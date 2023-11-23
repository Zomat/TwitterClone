<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Bus\IlluminateCommandBus;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;
use Modules\Shared\Services\SanctumAuthenticatedUserService;
use Modules\Shared\Services\UuidService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        $singletons = [
            CommandBus::class => IlluminateCommandBus::class,
            IdService::class => UuidService::class,
            IAuthenticatedUserService::class => SanctumAuthenticatedUserService::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                abstract: $abstract,
                concrete: $concrete,
            );
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
