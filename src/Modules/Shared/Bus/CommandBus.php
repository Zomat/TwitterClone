<?php declare(strict_types=1);

namespace Modules\Shared\Bus;

interface CommandBus
{
    public function dispatch(Command $command): mixed;

    public function register(array $map): void;
}
