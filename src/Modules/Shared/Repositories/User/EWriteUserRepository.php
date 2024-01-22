<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\User;

use App\Models\UserFollow;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\Repositories\DatabaseTransactions;
use Modules\Shared\Repositories\IDatabaseTransactions;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use App\Models\User;

class EWriteUserRepository extends DatabaseTransactions implements IWriteUserRepository
{
    public function create(Id $id, string $name, Email $email, string $password): void
    {
        User::factory()->create([
            'id' => $id->toNative(),
            'name' => $name,
            'email' => $email->toNative(),
            'password' => Hash::make($password)
        ]);
    }

    public function follow(Id $id, Id $followerId, Id $followedId, \DateTimeImmutable $createdAt): void
    {
        UserFollow::create([
            'id' => $id->toNative(),
            'follower_id' => $followerId->toNative(),
            'followed_id' => $followedId->toNative(),
            'created_at' => $createdAt,
        ]);
    }
}
