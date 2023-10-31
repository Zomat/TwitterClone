<?php declare(strict_types=1);

namespace Modules\Shared\Services;

use Modules\Shared\ValueObjects\Id;
use Ramsey\Uuid\Uuid;

class UuidService implements IdService
{
    public function generate(): Id
    {
        return Id::fromString(
            id: Uuid::uuid4()->toString(),
        );
    }
}
