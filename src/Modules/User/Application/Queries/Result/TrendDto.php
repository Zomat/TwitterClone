<?php declare(strict_types=1);

namespace Modules\User\Application\Queries\Result;

use Modules\Shared\Enums\NotificationType;

final readonly class TrendDto
{
    public function __construct(
        public string $id,
        public string $name,
        public int $count
    ) {}
}
