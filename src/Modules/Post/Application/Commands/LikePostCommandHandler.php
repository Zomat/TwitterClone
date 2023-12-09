<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Domain\IReadPostRepository;
use Modules\Post\Domain\IWritePostRepository;
use Modules\Post\Domain\PostAlreadyLikedException;
use Modules\Shared\Bus\CommandHandler;

class LikePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $writeRepository,
        protected IReadPostRepository $readRepository,
    ) {}

    public function handle(LikePostCommand $command)
    {
        $post = $this->readRepository->findById($command->postId);

        $post->like($command->id, $command->userId, $command->createdAt);
        $this->writeRepository->update($post);
    }
}
