<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Post\Domain\IReadPostRepository;
use Modules\Post\Domain\IWritePostRepository;
use Modules\Shared\Bus\CommandHandler;
use Modules\Shared\Services\INotificationService;
use Modules\Shared\ValueObjects\Id;

class CommentPostCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePostRepository $writeRepository,
        protected IReadPostRepository $readRepository,
        protected INotificationService $notificationService,
    ) {}

    public function handle(CommentPostCommand $command)
    {
        $this->writeRepository->beginTransaction();

        try {
            $post = $this->readRepository->findById($command->postId);

            $post->comment(
                commentId: $command->id,
                userId: $command->userId,
                content: $command->content,
                createdAt: $command->createdAt
            );

            $this->writeRepository->update($post);

            $this->notificationService->sendPostCommentedNotification(
                userId: Id::fromString($post->getPayload()['userId']),
                commentedById: $command->userId,
                comment: $command->content
            );

            $this->writeRepository->commit();
        } catch (\Exception $e) {
            $this->writeRepository->rollback();
            throw $e;
        }
    }
}
