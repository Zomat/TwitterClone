<?php declare(strict_types=1);

namespace Modules\User\Infrastructure\Queries;

use App\Models\Trend;
use Modules\User\Application\Queries\IGetTrendsQuery;
use Modules\User\Application\Queries\Result\TrendDto;

final class GetTrendsQuery implements IGetTrendsQuery
{
    public function ask(): array
    {
        $result = [];

        foreach (Trend::all()->sortBy('times_used') as $trend) {
            $result[] = new TrendDto(
                id: $trend->id,
                name: $trend->name,
                count: $trend->times_used
            );
        }

        return $result;
    }
}
