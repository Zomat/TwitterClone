<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Application\Commands\CreatePostCommand;
use Modules\Post\Domain\IWritePostRepository;
use Modules\Post\Domain\TrendService;
use Modules\Shared\Bus\CommandHandler;
use Modules\Post\Domain\Post;

class CreatePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $repository,
        protected TrendService $trendService
    ) {}

    public function handle(CreatePostCommand $command)
    {
        $this->repository->beginTransaction();

        try {
            $post = new Post;

            $post->create(
                id: $command->id,
                userId: $command->userId,
                content: $command->content,
                createdAt: $command->createdAt
            );

            $this->repository->create($post);
            $this->trendService->saveFromContent($command->content);

            $this->repository->commit();
        } catch (\Exception $e) {
            $this->repository->rollback();
            throw $e;
        }
    }
}
