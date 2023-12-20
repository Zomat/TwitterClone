<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Domain\IReadPostRepository;
use Modules\Post\Domain\IWritePostRepository;
use Modules\Shared\Bus\CommandHandler;

class CommentPostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $writeRepository,
        protected IReadPostRepository $readRepository,
    ) {}

    public function handle(CommentPostCommand $command)
    {
        $post = $this->readRepository->findById($command->postId);

        $post->comment($command->id, $command->userId, $command->content, $command->createdAt);
        $this->writeRepository->update($post);
    }
}
