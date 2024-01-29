<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Domain\IReadPostRepository;
use Modules\Post\Domain\IWritePostRepository;
use Modules\Shared\Bus\CommandHandler;

class UnlikePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $writeRepository,
        protected IReadPostRepository $readRepository,
    ) {}

    public function handle(UnlikePostCommand $command)
    {
        $post = $this->readRepository->findById($command->postId);

        $post->unlike($command->userId);
        $this->writeRepository->update($post);
    }
}
