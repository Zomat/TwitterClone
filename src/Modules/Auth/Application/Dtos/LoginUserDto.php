<?php declare(strict_types=1);

namespace Modules\Auth\Application\Dtos;

final class LoginUserDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
