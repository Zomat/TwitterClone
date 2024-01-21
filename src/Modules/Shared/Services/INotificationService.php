<?php declare(strict_types=1);

namespace Modules\Shared\Services;

use Modules\Shared\ValueObjects\Id;

interface INotificationService
{
    public function sendPostLikedNotification(Id $userId, Id $likedById): void;

    public function sendPostSharedNotification(Id $userId, Id $sharedById): void;

    public function sendPostCommentedNotification(Id $userId, Id $commentedById, string $comment): void;

    public function sendUserFollowedNotification(Id $userId, Id $followedById): void;
}
