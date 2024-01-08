<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Domain\IReadPostRepository;
use Modules\Post\Domain\IWritePostRepository;
use Modules\Post\Domain\Share;
use Modules\Shared\Bus\CommandHandler;
use Modules\Shared\Services\INotificationService;
use Modules\Shared\ValueObjects\Id;

class SharePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $writeRepository,
        protected IReadPostRepository $readRepository,
        protected INotificationService $notificationService,
    ) {}

    public function handle(SharePostCommand $command)
    {
        $this->writeRepository->beginTransaction();

        try {
            $post = $this->readRepository->findById($command->postId);

            $share = new Share(
                id: $command->id,
                postId: $command->postId,
                userId: $command->userId,
                content: $command->content,
                createdAt: $command->createdAt
            );

            $this->writeRepository->share(share: $share);

            $this->notificationService->sendPostSharedNotification(
                userId: Id::fromString($post->getPayload()['userId']),
                sharedById: $command->userId
            );

            $this->writeRepository->commit();
        } catch (\Exception $e) {
            $this->writeRepository->rollback();
            throw $e;
        }
    }
}
