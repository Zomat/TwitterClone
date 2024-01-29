<?php declare(strict_types=1);

namespace Modules\Post\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;

class UnlikePostCommand extends Command
{
    public function __construct(
        public readonly Id $userId,
        public readonly Id $postId,
    ) {}
}
