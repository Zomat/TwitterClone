<?php declare(strict_types=1);

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Commands\CreatePersonalAccessTokenCommand;
use Modules\Auth\Commands\CreatePersonalAccessTokenCommandHandler;
use Modules\Auth\Commands\CreateUserCommand;
use Modules\Auth\Commands\CreateUserCommandHandler;
use Modules\Auth\Commands\RevokeAllPersonalAccessTokenCommand;
use Modules\Auth\Queries\FindUserQuery;
use Modules\Auth\Queries\FindUserQueryHandler;
use Modules\Auth\Queries\LoginUserQuery;
use Modules\Auth\Queries\LoginUserQueryHandler;
use Modules\Auth\Repositories\IWritePersonalAccessTokenRepository;
use Modules\Auth\Repositories\WritePersonalAccessTokenRepository;
use Modules\Auth\Services\IAuthenticatedUserService;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Bus\QueryBus;
use Modules\Shared\Repositories\User\IReadUserRepository;
use Modules\Shared\Repositories\User\IWriteUserRepository;
use Modules\Shared\Repositories\User\ReadUserRepository;
use Modules\Shared\Repositories\User\WriteUserRepository;

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
            IWritePersonalAccessTokenRepository::class => WritePersonalAccessTokenRepository::class,
            IAuthenticatedUserService::class => IAuthenticatedUserService::class,
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
            CreateUserCommand::class => CreateUserCommandHandler::class,
            CreatePersonalAccessTokenCommand::class => CreatePersonalAccessTokenCommandHandler::class,
            RevokeAllPersonalAccessTokenCommand::class => RevokeAllPersonalAccessTokenCommandHandler::class,
        ]);

        $queryBus = app(QueryBus::class);

        $queryBus->register([
            FindUserQuery::class => FindUserQueryHandler::class,
            LoginUserQuery::class => LoginUserQueryHandler::class,
        ]);
    }
}
