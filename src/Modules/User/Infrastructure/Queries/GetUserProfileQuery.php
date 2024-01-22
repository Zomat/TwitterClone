<?php declare(strict_types=1);

namespace Modules\User\Infrastructure\Queries;

use App\Models\UserProfile;
use App\Models\User;
use Modules\Shared\Mappers\UserMapper;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IFileService;
use Modules\User\Application\Queries\IGetUserProfileQuery;
use Modules\User\Application\Queries\Result\UserProfileDto;
use Modules\Shared\ValueObjects\Id;

final class GetUserProfileQuery implements IGetUserProfileQuery
{
    public function __construct(
        private IFileService $fileService,
        private IAuthenticatedUserService $authService
    ) {}

    public function ask(Id $profileId): ?UserProfileDto
    {
        $profile = UserProfile::where('id', $profileId->toNative())->first();

        if ($profile === null) {
            return null;
        }

        $user = User::where('id', $profile->user_id)->first();

        if ($profile->picture_id !== null) {
            $picture = $this->fileService->getByFilename('profile-pictures/', $profile->picture_id);
        }

        $authUser = auth('sanctum')->user();
        if ($authUser !== null) {
            $followedByAuthUser = $authUser->follows->contains($user);
            $followsAuthUser = $user->follows->contains($authUser);
        }

        return new UserProfileDto(
            userId: $user->id,
            profileId: $profile->id,
            nick: $profile->nick,
            bio: $profile->bio,
            picturePath: isset($picture) ? $picture->fullpath : null,
            followsAuthUser: $followsAuthUser ?? null,
            followedByAuthUser: $followedByAuthUser ?? null
        );
    }
}
