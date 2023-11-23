<?php declare(strict_types=1);

namespace Modules\Post\Domain\Repositories;

use Modules\Shared\ValueObjects\Id;

interface IWritePostRepository
{
    public function create(Id $id, Id $userId, string $content, \DateTimeImmutable $createdAt): void;
}
