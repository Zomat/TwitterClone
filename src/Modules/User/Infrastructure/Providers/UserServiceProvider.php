<?php declare(strict_types=1);

namespace Modules\User\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Services\IFileService;
use Modules\Shared\Services\StorageFileService;
use Modules\User\Application\Commands\CreatePersonalAccessTokenCommand;
use Modules\User\Application\Commands\CreatePersonalAccessTokenCommandHandler;
use Modules\User\Application\Commands\CreateUserCommand;
use Modules\User\Application\Commands\CreateUserCommandHandler;
use Modules\User\Application\Commands\RevokeAllPersonalAccessTokenCommand;
use Modules\User\Application\Commands\RevokeAllPersonalAccessTokenCommandHandler;
use Modules\User\Application\Queries\FindUserQuery;
use Modules\User\Application\Queries\IFindUserQuery;
use Modules\User\Application\Queries\ILoginUserQuery;
use Modules\User\Application\Queries\LoginUserQuery;
use Modules\User\Domain\Repositories\IWritePersonalAccessTokenRepository;
use Modules\User\Infrastructure\Repositories\WritePersonalAccessTokenRepository;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Repositories\User\IReadUserRepository;
use Modules\Shared\Repositories\User\IWriteUserRepository;
use Modules\Shared\Repositories\User\ReadUserRepository;
use Modules\Shared\Repositories\User\WriteUserRepository;
use Modules\Shared\Repositories\UserProfile\IUserProfileRepository;
use Modules\Shared\Repositories\UserProfile\UserProfileRepository;

class UserServiceProvider extends ServiceProvider
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

            IUserProfileRepository::class => UserProfileRepository::class,
            IFileService::class => StorageFileService::class,
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
