<?php declare(strict_types=1);

namespace Modules\User\Infrastructure\Queries;

use App\Models\User;
use Modules\User\Application\Queries\IGetUserNotificationsQuery;
use Modules\Shared\ValueObjects\Id;
use Modules\User\Application\Queries\Result\NotificationDto;

final class GetUserNotificationsQuery implements IGetUserNotificationsQuery
{
    public function ask(Id $userId): array
    {
        $user = User::where('id', $userId->toNative())->first();

        $result = [];

        foreach ($user->notifications->sortBy('sent_date') as $notif) {
            $result[] = new NotificationDto(
                id: $notif->id,
                type: $notif->type,
                content: $notif->content,
                sentDate: $notif->sent_date,
                read: (bool) $notif->read_mark
            );
        }

        return $result;
    }
}
