<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Application\Commands\CreatePostCommand;
use Modules\Post\Domain\IReadPostRepository;
use Modules\Post\Domain\IWritePostRepository;
use Modules\Shared\Bus\CommandHandler;
use Modules\Post\Domain\Post;

class LikePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $writeRepository,
        protected IReadPostRepository $readRepository,
    ) {}

    public function handle(LikePostCommand $command)
    {
        // Load data
        $post = $this->readRepository->findById($command->postId);

        //$post->like();
        //$this->repository->create($post);
    }
}
