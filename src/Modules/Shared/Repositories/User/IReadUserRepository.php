<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\User;

use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\Entities\User;

interface IReadUserRepository
{
    public function find(Id $id): ?User;

    public function findByEmail(Email $email): ?User;

    public function follows(Id $followerId, Id $followedId): bool;
}
