<?php declare(strict_types=1);

namespace Modules\User\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\User\Application\Queries\IGetHomeFeedQuery;
use Modules\Shared\ValueObjects\Id;
use Illuminate\Support\Facades\Cache;
use Modules\User\Application\Queries\IGetTrendsQuery;

class HomeQueryController extends Controller
{
    public function getHomeFeed(IGetHomeFeedQuery $query): JsonResponse
    {
        $userId = Id::fromString(auth()->user()->id);
        $cacheKey = 'user_feed_' . $userId->toNative();
        $batch = 15;

        $feed = Cache::remember($cacheKey, now()->addSeconds(5), function () use ($query, $userId, $batch) {
            return $query->ask($userId, $batch);
        });

        return new JsonResponse($feed);
    }

    public function getTrends(IGetTrendsQuery$query): JsonResponse
    {
        $trends = $query->ask();

        return new JsonResponse($trends);
    }
}
