<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;

class CreatePostCommand extends Command
{
    public function __construct(
        public readonly Id $id,
        public readonly Id $userId,
        public readonly string $content,
        public readonly \DateTimeImmutable $createdAt,
    ) {}
}
