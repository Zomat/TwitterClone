<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\User;

use Modules\Shared\Mappers\UserMapper;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\Entities\User;
use App\Models\User as EloquentUser;

class ReadUserRepository implements IReadUserRepository
{
    public function find(Id $id): ?User
    {
        $user = EloquentUser::where('id', $id->toNative())->first();

        if ($user === null) {
            return null;
        }

        return UserMapper::toEntity($user);
    }

    public function findByEmail(Email $email): ?User
    {
        $user = EloquentUser::where('email', $email->toNative())->first();

        if ($user === null) {
            return null;
        }

        return UserMapper::toEntity($user);
    }
}
