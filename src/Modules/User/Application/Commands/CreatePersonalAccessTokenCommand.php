<?php declare(strict_types=1);

namespace Modules\User\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;

class CreatePersonalAccessTokenCommand extends Command
{
    public function __construct(
        public readonly Id $userId,
        public readonly string $token,
    ) {}
}
