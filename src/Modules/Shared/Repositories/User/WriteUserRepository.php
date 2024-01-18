<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\User;

use Illuminate\Support\Facades\Hash;
use Modules\Shared\Repositories\DatabaseTransactions;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use App\Models\User;

class WriteUserRepository implements IWriteUserRepository
{
    use DatabaseTransactions;

    public function create(Id $id, string $name, Email $email, string $password): void
    {
        User::factory()->create([
            'id' => $id->toNative(),
            'name' => $name,
            'email' => $email->toNative(),
            'password' => Hash::make($password)
        ]);
    }
}
