<?php declare(strict_types=1);

namespace Modules\Shared\Repositories;

class DatabaseTransactions implements IDatabaseTransactions
{
    public function beginTransaction(): void
    {
        \DB::beginTransaction();
    }

    public function commit(): void
    {
        \DB::commit();
    }

    public function rollback(): void
    {
        \DB::rollBack();
    }
}
