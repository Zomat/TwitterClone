<?php declare(strict_types=1);

namespace Modules\User\Application\Dtos;

use Modules\Shared\ValueObjects\Id;
use Modules\Shared\ValueObjects\Email;

final class UserDto
{
    public function __construct(
        public readonly Id $id,
        public readonly string $name,
        public readonly Email $email,
        public readonly string $password,
    ) {}
}
