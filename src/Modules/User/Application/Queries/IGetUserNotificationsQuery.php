<?php declare(strict_types=1);

namespace Modules\User\Application\Queries;

use Modules\Shared\ValueObjects\Id;

interface IGetUserNotificationsQuery
{
    /*@return NotificationDto[] */
    public function ask(Id $userId): array;
}
