<?php declare(strict_types=1);

namespace Modules\Auth\Commands;

use App\Bus\Command;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;

class CreateUserCommand extends Command
{
    public function __construct(
        public readonly Id $id,
        public readonly string $name,
        public readonly Email $email,
        public readonly string $password,
    ) {}
}
