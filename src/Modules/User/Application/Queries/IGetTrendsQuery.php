<?php declare(strict_types=1);

namespace Modules\User\Application\Queries;

interface IGetTrendsQuery
{
    /* @returns TrendDto[] */
    public function ask(): array;
}
