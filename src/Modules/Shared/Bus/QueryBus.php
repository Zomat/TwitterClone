<?php declare(strict_types=1);

namespace Modules\Shared\Bus;

interface QueryBus
{
    public function ask(Query $query): mixed;

    public function register(array $map): void;
}
