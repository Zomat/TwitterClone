<?php declare(strict_types=1);

namespace Modules\Shared\Services;

use Illuminate\Support\Carbon;
use Modules\Shared\Enums\NotificationType;
use Modules\Shared\Repositories\Notification\INotificationRepository;
use Modules\Shared\Repositories\User\IReadUserRepository;
use Modules\Shared\Repositories\UserProfile\IUserProfileRepository;
use Modules\Shared\ValueObjects\Id;

class DatabaseNotificationService implements INotificationService
{
    public function __construct(
        private INotificationRepository $notificationRepository,
        private IReadUserRepository $userReadRepository,
        protected IUserProfileRepository $userProfileRepository,
        private IdService $idService,
    ) {}

    public function sendPostLikedNotification(Id $userId, Id $likedById): void
    {
        $likedByUser = $this->userReadRepository->find($likedById);

        if ($likedByUser == null) {
            throw new \Exception("Liked by user not found");
        }

        $content = "Post liked by " . $likedByUser->getEmail()->toNative();

        $id = $this->idService->generate();

        $this->notificationRepository->save(
            id: $id,
            userId: $userId,
            content: $content,
            type: NotificationType::POST_LIKED,
            sentDate: Carbon::now()->toDateTimeImmutable()
        );
    }

    public function sendPostSharedNotification(Id $userId, Id $sharedById): void
    {
        $sharedByUser = $this->userReadRepository->find($sharedById);

        if ($sharedByUser == null) {
            throw new \Exception("Shared by user not found");
        }

        $content = "Post shared by " . $sharedByUser->getEmail()->toNative();

        $id = $this->idService->generate();

        $this->notificationRepository->save(
            id: $id,
            userId: $userId,
            content: $content,
            type: NotificationType::POST_SHARED,
            sentDate: Carbon::now()->toDateTimeImmutable()
        );
    }

    public function sendPostCommentedNotification(Id $userId, Id $commentedById, string $comment): void
    {
        $commentedByUser = $this->userReadRepository->find($commentedById);

        if ($commentedByUser == null) {
            throw new \Exception("Shared by user not found");
        }

        $content = "Post commented by " . $commentedByUser->getEmail()->toNative() . '\n';
        $content .= "Comment: " . $comment;

        $id = $this->idService->generate();

        $this->notificationRepository->save(
            id: $id,
            userId: $userId,
            content: $content,
            type: NotificationType::POST_COMMENTED,
            sentDate: Carbon::now()->toDateTimeImmutable()
        );
    }

    public function sendUserFollowedNotification(Id $userId, Id $followedById): void
    {
        $followedByUser = $this->userReadRepository->find($followedById);

        if ($followedByUser == null) {
            throw new \Exception("Followed by user not found");
        }

        $content = $this->userProfileRepository
            ->findByUserId($followedByUser->getId())
            ->getNick() . " follows you!";

        $id = $this->idService->generate();

        $this->notificationRepository->save(
            id: $id,
            userId: $userId,
            content: $content,
            type: NotificationType::USER_FOLLOWED,
            sentDate: Carbon::now()->toDateTimeImmutable()
        );
    }
}