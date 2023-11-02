<?php declare(strict_types=1);

namespace Modules\Auth\Queries;

use Modules\Shared\Bus\Query;
use Modules\Shared\ValueObjects\Id;

class FindUserQuery extends Query
{
    public function __construct(
        public readonly Id $id
    ) {}
}
