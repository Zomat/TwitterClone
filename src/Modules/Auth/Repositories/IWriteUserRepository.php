<?php declare(strict_types=1);

namespace Modules\Auth\Repositories;

use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;

interface IWriteUserRepository
{
    public function create(Id $id, string $name, Email $email, string $password): void;
}
