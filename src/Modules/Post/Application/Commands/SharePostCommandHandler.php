<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Domain\IWritePostRepository;
use Modules\Post\Domain\Share;
use Modules\Shared\Bus\CommandHandler;

class SharePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $writeRepository,
    ) {}

    public function handle(SharePostCommand $command)
    {
        $share = new Share(
            id: $command->id,
            postId: $command->postId,
            userId: $command->userId,
            content: $command->content,
            createdAt: $command->createdAt
        );

        $this->writeRepository->share(share: $share);
    }
}
