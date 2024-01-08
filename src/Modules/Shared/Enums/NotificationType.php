<?php declare(strict_types=1);

namespace Modules\Shared\Enums;

enum NotificationType: int
{
    case POST_LIKED = 1;
    case POST_SHARED = 2;
}
