<?php

namespace Modules\Auth\Providers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Commands\CreateUserCommand;
use Modules\Auth\Commands\CreateUserCommandHandler;
use Modules\Auth\Queries\FindUserQuery;
use Modules\Auth\Queries\FindUserQueryHandler;
use Modules\Auth\Queries\LoginUserQuery;
use Modules\Auth\Queries\LoginUserQueryHandler;
use Modules\Auth\Repositories\IReadUserRepository;
use Modules\Auth\Repositories\IWriteUserRepository;
use Modules\Auth\Repositories\ReadUserRepository;
use Modules\Auth\Repositories\WriteUserRepository;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $singletons = [
            IReadUserRepository::class => ReadUserRepository::class,
            IWriteUserRepository::class => WriteUserRepository::class,
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
        $commandBus = app(CommandBus::class);

        $commandBus->register([
            CreateUserCommand::class => CreateUserCommandHandler::class
        ]);

        $queryBus = app(QueryBus::class);

        $queryBus->register([
            FindUserQuery::class => FindUserQueryHandler::class,
            LoginUserQuery::class => LoginUserQueryHandler::class,
        ]);
    }
}
