<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Bus\IlluminateCommandBus;
use Modules\Shared\Repositories\Notification\INotificationRepository;
use Modules\Shared\Repositories\Notification\NotificationRepository;
use Modules\Shared\Services\DatabaseNotificationService;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;
use Modules\Shared\Services\INotificationService;
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
            INotificationService::class => DatabaseNotificationService::class,
            INotificationRepository::class => NotificationRepository::class,
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
