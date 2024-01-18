<?php declare(strict_types=1);

namespace Modules\User\Application\Queries;

use Modules\Shared\ValueObjects\Email;
use Modules\Shared\Entities\User;

interface ILoginUserQuery
{
    public function ask(Email $email, string $password): ?User;
}
