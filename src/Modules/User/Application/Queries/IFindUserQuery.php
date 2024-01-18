<?php declare(strict_types=1);

namespace Modules\User\Application\Queries;

use Modules\Shared\ValueObjects\Id;
use Modules\Shared\Entities\User;

interface IFindUserQuery
{
    public function ask(Id $userId): ?User;
}
