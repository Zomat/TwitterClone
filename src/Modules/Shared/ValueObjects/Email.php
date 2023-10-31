<?php declare(strict_types=1);

namespace Modules\Shared\ValueObjects;

use InvalidArgumentException;

class Email
{
    public function __construct(protected string $email)
    {
        if (! filter_var($email, filter: FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address provided");
        }
    }

    public static function fromString(string $email): Email
    {
        return new self($email);
    }

    public function toNative(): string
    {
        return $this->email;
    }
}
