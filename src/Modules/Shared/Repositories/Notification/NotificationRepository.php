<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\Notification;

use App\Models\Notification as EloquentNotification;
use Modules\Shared\Enums\NotificationType;
use Modules\Shared\ValueObjects\Id;

final class NotificationRepository implements INotificationRepository
{
    public function save(
        Id $id,
        Id $userId,
        string $content,
        NotificationType $type,
        \DateTimeImmutable $sentDate
    ): void {
        EloquentNotification::create([
            'id' => $id->toNative(),
            'user_id' => $userId->toNative(),
            'content' => $content,
            'type' => $type,
            'read_mark' => false,
            'sent_date' => $sentDate->format('Y-m-d H:i:s'),
        ]);
    }
}
