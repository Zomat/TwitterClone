<?php declare(strict_types=1);

namespace Modules\User\Domain;

use Modules\Shared\ValueObjects\Id;

interface IWritePersonalAccessTokenRepository
{
    public function create(Id $userId, string $token, array $abilities = ['*'], \DateTimeInterface $expiresAt = null): void;

    public function revokeAll(Id $userId): void;
}
