<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Domain\IReadPostRepository;
use Modules\Post\Domain\IWritePostRepository;
use Modules\Shared\Bus\CommandHandler;
use Modules\Shared\Services\INotificationService;
use Modules\Shared\ValueObjects\Id;

class LikePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $writeRepository,
        protected IReadPostRepository $readRepository,
        protected INotificationService $notificationService,
    ) {}

    public function handle(LikePostCommand $command)
    {
        $this->writeRepository->beginTransaction();

        try {
            $post = $this->readRepository->findById($command->postId);

            $post->like($command->id, $command->userId, $command->createdAt);
            $this->writeRepository->update($post);

            $this->notificationService->sendPostLikedNotification(
                userId: Id::fromString($post->getPayload()['userId']),
                likedById: $command->userId
            );

            $this->writeRepository->commit();
        } catch (\Exception $e) {
            $this->writeRepository->rollback();
            throw $e;
        }
    }
}
