<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\User;

use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\Entities\User;
use Illuminate\Support\Facades\DB;

class ReadUserRepository implements IReadUserRepository
{
    public function find(Id $id): ?User
    {
        $user = DB::table('users')->where('id', $id->toNative())->first();

        if ($user === null) {
            return null;
        }

        return new User(
            id: Id::fromString($user->id),
            name: $user->name,
            email: Email::fromString($user->email),
            password: $user->password,
            emailVerifiedAt: $user->email_verified_at ? new \DateTime($user->email_verified_at) : null,
            rememberToken: $user->remember_token
        );
    }

    public function findByEmail(Email $email): ?User
    {
        $user = DB::table('users')->where('email', $email->toNative())->first();

        if ($user === null) {
            return null;
        }

        return new User(
            id: Id::fromString($user->id),
            name: $user->name,
            email: Email::fromString($user->email),
            password: $user->password,
            emailVerifiedAt: $user->email_verified_at ? new \DateTime($user->email_verified_at) : null,
            rememberToken: $user->remember_token
        );
    }

    public function follows(Id $followerId, Id $followedId): bool
    {
        return DB::table('follows')
            ->where('follower_id', $followerId->toNative())
            ->where('followed_id', $followedId->toNative())
            ->count() > 0;
    }
}
