<?php declare(strict_types=1);

namespace Modules\Shared\Bus;

use Modules\Shared\Bus\Query;
use Illuminate\Bus\Dispatcher;

class IlluminateQueryBus implements QueryBus
{
    public function __construct(
        protected Dispatcher $bus,
    ) {}

    public function ask(Query $query): mixed
    {
        return $this->bus->dispatch($query);
    }

    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}
