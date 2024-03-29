<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\User;

use Illuminate\Support\Facades\DB;
use Modules\Shared\Repositories\DatabaseTransactions;
use Modules\Shared\Repositories\IDatabaseTransactions;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;

class WriteUserRepository extends DatabaseTransactions implements IWriteUserRepository
{
    public function create(Id $id, string $name, Email $email, string $password): void
    {
        DB::table('users')->insert([
            'id' => $id->toNative(),
            'name' => $name,
            'email' => $email->toNative(),
            'password' => bcrypt($password),
        ]);
    }

    public function follow(Id $id, Id $followerId, Id $followedId, \DateTimeImmutable $createdAt): void
    {
        DB::table('follows')->insert([
            'id' => $id->toNative(),
            'follower_id' => $followerId->toNative(),
            'followed_id' => $followedId->toNative(),
            'created_at' => $createdAt,
        ]);
    }
}
