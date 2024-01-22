<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\UserProfile;

use App\Models\UserProfile as EloquentUserProfile;
use App\Models\User as EloquentUser;
use Modules\Shared\Entities\UserProfile;
use Modules\Shared\Mappers\UserProfileMapper;
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
            'picture_id' => $pictureId?->toNative()
        ]);
    }

    public function find(Id $id): UserProfile
    {
        $profile = EloquentUserProfile::where('id', $id->toNative())->firstOrFail();

        return UserProfileMapper::toEntity($profile);
    }

    public function findByUserId(Id $id): UserProfile
    {
        $profile = EloquentUser::where('id', $id->toNative())->first()->profile()->first();
        return UserProfileMapper::toEntity($profile);
    }

    public function edit(
        Id $id,
        ?string $nick = null,
        ?string $bio = null,
        ?Id $pictureId = null
    ): void {
        $profile = EloquentUserProfile::where('id', $id->toNative())->firstOrFail();

        if ($nick !== null) {
            $profile->nick = $nick;
        }

        if ($bio !== null) {
            $profile->bio = $bio;
        }

        if ($pictureId !== null) {
            $profile->picture_id = $pictureId->toNative();
        }

        $profile->save();
    }
}
