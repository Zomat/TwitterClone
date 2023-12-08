<?php declare(strict_types=1);

namespace Modules\Shared;

abstract class AggregateRoot
{
    abstract public function getPayload(): array;
}
