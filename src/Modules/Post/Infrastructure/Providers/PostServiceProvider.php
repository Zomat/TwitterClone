<?php declare(strict_types=1);

namespace Modules\Post\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Post\Application\Commands\CreatePostCommand;
use Modules\Post\Application\Commands\CreatePostCommandHandler;
use Modules\Post\Domain\Repositories\IWritePostRepository;
use Modules\Post\Infrastructure\Repositories\WritePostRepository;
use Modules\Shared\Bus\CommandBus;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $singletons = [
            IWritePostRepository::class => WritePostRepository::class,
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
            CreatePostCommand::class => CreatePostCommandHandler::class,
        ]);
    }
}
