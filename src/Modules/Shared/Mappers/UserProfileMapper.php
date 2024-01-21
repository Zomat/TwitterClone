<?php declare(strict_types=1);

namespace Modules\Shared\Mappers;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserProfile as EloquentUserProfile;
use Modules\Shared\Entities\BaseEntity;
use Modules\Shared\Entities\UserProfile;
use Modules\Shared\ValueObjects\Id;

class UserProfileMapper implements IMapper
{
    public static function toEntity(Model $model): BaseEntity
    {
        return new UserProfile(
            id: Id::fromString($model->id),
            userId: Id::fromString($model->user_id),
            nick: $model->nick,
            bio: $model->bio,
            pictureId: $model->picture_id ? Id::fromString($model->picture_id) : null
        );
    }

    public static function toModel(BaseEntity $entity): Model
    {
        $model = new EloquentUserProfile();

        $model->id = $entity->getId()->toNative();
        $model->user_id = $entity->getUserId()->toNative();
        $model->nick = $entity->getNick();
        $model->bio = $entity->getBio();
        $model->profileId = $entity->getPictureId();

        return $model;
    }
}
