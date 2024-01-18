<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\UserProfile;

use Modules\Shared\ValueObjects\Id;

class UserProfileRepository implements IUserProfileRepository
{
    public function create(
        Id $id,
        Id $userId,
        string $nick,
        string $bio,
        ?Id $pictureId
    ): void
    {
        \DB::table('user_profiles')->insert([
            'id' => $id->toNative(),
            'user_id' => $userId->toNative(),
            'nick' => $nick,
            'bio' => $bio,
            'pictureId' => $pictureId?->toNative()
        ]);
    }
}
