<?php declare(strict_types=1);

namespace Modules\User\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;

class FollowUserCommand extends Command
{
    public function __construct(
        public readonly Id $id,
        public readonly Id $followerId,
        public readonly Id $followedId,
        public readonly \DateTimeImmutable $createdAt,
    ) {}
}
