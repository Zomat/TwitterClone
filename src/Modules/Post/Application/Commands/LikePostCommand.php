<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;

class LikePostCommand extends Command
{
    public function __construct(
        public readonly Id $id,
        public readonly Id $userId,
        public readonly Id $postId,
        public readonly \DateTimeImmutable $createdAt,
    ) {}
}
