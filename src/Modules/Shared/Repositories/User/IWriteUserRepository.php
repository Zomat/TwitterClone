<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\User;

use Modules\Shared\Repositories\IDatabaseTransactions;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;

interface IWriteUserRepository extends IDatabaseTransactions
{
    public function create(Id $id, string $name, Email $email, string $password): void;
}
