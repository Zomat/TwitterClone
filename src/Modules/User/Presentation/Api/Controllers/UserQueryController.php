<?php declare(strict_types=1);

namespace Modules\User\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\User\Application\Queries\IGetUserProfileQuery;
use Modules\Shared\ValueObjects\Id;
use Illuminate\Http\Response;

class UserQueryController extends Controller
{
    public function getUserProfile(string $profileId, IGetUserProfileQuery $query): JsonResponse
    {
        $profile = $query->ask(Id::fromString($profileId));

        if ($profile === null) {
            return response()->json(['error' => 'Profile not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($profile);
    }
}
