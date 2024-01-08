<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\Notification;

use Modules\Shared\Enums\NotificationType;
use Modules\Shared\ValueObjects\Id;

interface INotificationRepository
{
    public function save(
        Id $id,
        Id $userId,
        string $content,
        NotificationType $type,
        \DateTimeImmutable $sentDate
    );
}
