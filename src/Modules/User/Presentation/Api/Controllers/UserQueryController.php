<?php declare(strict_types=1);

namespace Modules\User\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Modules\User\Application\Queries\IGetUserFeedQuery;
use Modules\User\Application\Queries\IGetUserNotificationsQuery;
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

    public function getUserFeed(string $profileId, IGetUserFeedQuery $query): JsonResponse
    {
        $profile = UserProfile::where('id', $profileId)->first();

        if ($profile === null) {
            return response()->json(['error' => 'Profile not found'], Response::HTTP_NOT_FOUND);
        }

        $batch = 15;
        $feed = $query->ask(Id::fromString($profile->user->id), $batch);

        return new JsonResponse($feed);
    }

    public function getUserNotifications(IGetUserNotificationsQuery $query): JsonResponse
    {
        $notifs = $query->ask(Id::fromString(auth()->user()->id));

        return new JsonResponse($notifs);
    }
}
