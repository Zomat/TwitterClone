<?php declare(strict_types=1);

namespace Modules\Auth\Repositories;

use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;

interface IReadUserRepository
{
    public function find(Id $id): ?object;

    public function findByEmail(Email $email): ?object;
}
