<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Application\Commands\CreatePostCommand;
use Modules\Post\Domain\Repositories\IWritePostRepository;
use Modules\Shared\Bus\CommandHandler;

class CreatePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $repository
    ) {}

    public function handle(CreatePostCommand $command)
    {
        $this->repository->create(
            id: $command->id,
            userId: $command->userId,
            content: $command->content,
            createdAt: $command->createdAt
        );
    }
}
