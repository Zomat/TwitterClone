<?php declare(strict_types=1);

namespace Modules\Shared\Services;

use Modules\Shared\ValueObjects\Id;

interface IdService
{
    public function generate(): Id;
}
