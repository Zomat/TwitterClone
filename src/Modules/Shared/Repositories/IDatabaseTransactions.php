<?php declare(strict_types=1);

namespace Modules\Shared\Repositories;

interface IDatabaseTransactions
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}
