<?php declare(strict_types=1);

namespace Modules\User\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\User\Application\Queries\IGetHomeFeedQuery;
use Modules\Shared\ValueObjects\Id;

class HomeQueryController extends Controller
{
    public function getHomeFeed(IGetHomeFeedQuery $query): JsonResponse
    {
        $batch = 15;
        $feed = $query->ask(Id::fromString(auth()->user()->id), $batch);

        return new JsonResponse($feed);
    }
}
