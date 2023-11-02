<?php declare(strict_types=1);

namespace Modules\Auth\Queries;

use Modules\Shared\ValueObjects\Email;
use Modules\Shared\Bus\Query;

class LoginUserQuery extends Query
{
    public function __construct(
        public readonly Email $email,
        public readonly string $password
    ) {}
}
