<?php declare(strict_types=1);

namespace Modules\Shared\Entities;

use Modules\Shared\ValueObjects\Id;
use Modules\Shared\ValueObjects\Email;

class User extends BaseEntity
{
    public function __construct(
        private Id $id,
        private string $name,
        private Email $email,
        private string $password,
        private ?\DateTime $emailVerifiedAt = null,
        private ?string $rememberToken = null
    ) {}

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmailVerifiedAt(): ?\DateTime
    {
        return $this->emailVerifiedAt;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setEmailVerifiedAt(?\DateTime $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    public function setRememberToken(?string $rememberToken): void
    {
        $this->rememberToken = $rememberToken;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toNative(),
            'name' => $this->name,
            'email' => $this->email->toNative(),
            //'password' => $this->password,
            'email_verified_at' => $this->emailVerifiedAt,
            'remember_token' => $this->rememberToken,
        ];
    }
}
