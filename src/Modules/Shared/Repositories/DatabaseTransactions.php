<?php declare(strict_types=1);

namespace Modules\Shared\Repositories;

trait DatabaseTransactions
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
