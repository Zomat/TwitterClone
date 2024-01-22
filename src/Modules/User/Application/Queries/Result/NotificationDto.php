<?php declare(strict_types=1);

namespace Modules\User\Application\Queries\Result;

use Modules\Shared\Enums\NotificationType;

final readonly class NotificationDto
{
    public function __construct(
        public string $id,
        public NotificationType $type,
        public string $content,
        public string $sentDate,
        public bool $read
    ) {}
}
