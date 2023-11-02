<?php declare(strict_types=1);

namespace Modules\Auth\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;

class RevokeAllPersonalAccessTokenCommand extends Command
{
    public function __construct(
        public readonly Id $userId,
    ) {}
}
