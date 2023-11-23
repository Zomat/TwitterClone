<?php declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Application\Commands\CreatePersonalAccessTokenCommand;
use Modules\Auth\Application\Commands\CreatePersonalAccessTokenCommandHandler;
use Modules\Auth\Application\Commands\CreateUserCommand;
use Modules\Auth\Application\Commands\CreateUserCommandHandler;
use Modules\Auth\Application\Commands\RevokeAllPersonalAccessTokenCommand;
use Modules\Auth\Application\Commands\RevokeAllPersonalAccessTokenCommandHandler;
use Modules\Auth\Application\Queries\FindUserQuery;
use Modules\Auth\Application\Queries\IFindUserQuery;
use Modules\Auth\Application\Queries\ILoginUserQuery;
use Modules\Auth\Application\Queries\LoginUserQuery;
use Modules\Auth\Domain\Repositories\IWritePersonalAccessTokenRepository;
use Modules\Auth\Infrastructure\Repositories\WritePersonalAccessTokenRepository;
use Modules\Shared\Bus\CommandBus;
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

            ILoginUserQuery::class => LoginUserQuery::class,
            IFindUserQuery::class => FindUserQuery::class,
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
    }
}
