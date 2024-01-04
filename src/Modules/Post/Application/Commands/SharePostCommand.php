<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;

class SharePostCommand extends Command
{
    public function __construct(
        public readonly Id $id,
        public readonly Id $userId,
        public readonly Id $postId,
        public readonly string $content,
        public readonly \DateTime $createdAt,
    ) {}
}
