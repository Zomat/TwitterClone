<?php declare(strict_types=1);

namespace Modules\User\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Repositories\User\EReadUserRepository;
use Modules\Shared\Repositories\User\EWriteUserRepository;
use Modules\Shared\Services\IFileService;
use Modules\Shared\Services\StorageFileService;
use Modules\User\Application\Commands\CreatePersonalAccessTokenCommand;
use Modules\User\Application\Commands\CreatePersonalAccessTokenCommandHandler;
use Modules\User\Application\Commands\CreateUserCommand;
use Modules\User\Application\Commands\CreateUserCommandHandler;
use Modules\User\Application\Commands\EditUserProfileCommand;
use Modules\User\Application\Commands\EditUserProfileCommandHandler;
use Modules\User\Application\Commands\FollowUserCommand;
use Modules\User\Application\Commands\FollowUserCommandHandler;
use Modules\User\Application\Commands\RevokeAllPersonalAccessTokenCommand;
use Modules\User\Application\Commands\RevokeAllPersonalAccessTokenCommandHandler;
use Modules\User\Application\Queries\FindUserQuery;
use Modules\User\Application\Queries\IFindUserQuery;
use Modules\User\Application\Queries\IGetHomeFeedQuery;
use Modules\User\Application\Queries\IGetUserFeedQuery;
use Modules\User\Application\Queries\IGetUserNotificationsQuery;
use Modules\User\Application\Queries\IGetUserProfileQuery;
use Modules\User\Application\Queries\ILoginUserQuery;
use Modules\User\Application\Queries\LoginUserQuery;
use Modules\User\Domain\IWritePersonalAccessTokenRepository;
use Modules\User\Infrastructure\Queries\GetUserFeedQuery;
use Modules\User\Infrastructure\Queries\GetUserNotificationsQuery;
use Modules\User\Infrastructure\Queries\GetUserProfileQuery;
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
            // IReadUserRepository::class => EReadUserRepository::class,
            // IWriteUserRepository::class => EWriteUserRepository::class,
            IWritePersonalAccessTokenRepository::class => WritePersonalAccessTokenRepository::class,

            ILoginUserQuery::class => LoginUserQuery::class,
            IFindUserQuery::class => FindUserQuery::class,

            IUserProfileRepository::class => UserProfileRepository::class,
            IFileService::class => StorageFileService::class,

            IGetUserProfileQuery::class => GetUserProfileQuery::class,
            IGetHomeFeedQuery::class => \Modules\User\Infrastructure\Queries\GetHomeFeedQuery::class,
            IGetUserFeedQuery::class => GetUserFeedQuery::class,
            IGetUserNotificationsQuery::class => GetUserNotificationsQuery::class
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
            // Commands
            CreateUserCommand::class => CreateUserCommandHandler::class,
            FollowUserCommand::class => FollowUserCommandHandler::class,
            CreatePersonalAccessTokenCommand::class => CreatePersonalAccessTokenCommandHandler::class,
            RevokeAllPersonalAccessTokenCommand::class => RevokeAllPersonalAccessTokenCommandHandler::class,
            EditUserProfileCommand::class => EditUserProfileCommandHandler::class,
        ]);
    }
}
