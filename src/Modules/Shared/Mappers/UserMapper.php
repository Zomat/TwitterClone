<?php declare(strict_types=1);

namespace Modules\Shared\Mappers;

use Modules\Shared\Entities\BaseEntity;
use Modules\Shared\Entities\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as EloquentUser;

use Modules\Shared\ValueObjects\Id;
use Modules\Shared\ValueObjects\Email;

class UserMapper implements IMapper
{
    public static function toEntity(Model $model): BaseEntity
    {
        return new User(
            id: Id::fromString($model->id),
            name: $model->name,
            email: Email::fromString($model->email),
            password: $model->password,
            emailVerifiedAt: $model->email_verified_at,
            rememberToken: $model->remember_token
        );
    }

    public static function toModel(BaseEntity $entity): Model
    {
        $userModel = new EloquentUser();

        $userModel->id = $entity->getId()->toNative();
        $userModel->name = $entity->getName();
        $userModel->email = $entity->getEmail()->toNative();
        $userModel->password = $entity->getPassword();
        $userModel->email_verified_at = $entity->getEmailVerifiedAt();
        $userModel->remember_token = $entity->getRememberToken();

        return $userModel;
    }
}
