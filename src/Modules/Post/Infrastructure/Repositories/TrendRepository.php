<?php declare(strict_types=1);

namespace Modules\Post\Infrastructure\Repositories;

use App\Models\Trend;
use Modules\Post\Domain\ITrendRepository;
use Modules\Shared\Services\IdService;

final class TrendRepository implements ITrendRepository
{
    public function __construct(
        private IdService $idService
    ) {}

    public function add(string $trend): void
    {
        $trendModel = Trend::where('name', $trend)->first();

        if (!is_null($trendModel)) {
            $trendModel->increment('times_used');
            $trendModel->save();

            return;
        }

        $trendModel = new Trend();

        $trendModel->id = $this->idService->generate()->toNative();
        $trendModel->name = $trend;
        $trendModel->times_used = 1;

        $trendModel->save();
    }
}
