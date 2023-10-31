<?php declare(strict_types=1);

namespace Modules\Auth\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;

class WriteUserRepository implements IWriteUserRepository
{
    public function create(Id $id, string $name, Email $email, string $password): void
    {
        DB::table('users')->insert([
            'id' => $id->toNative(),
            'name' => $name,
            'email' => $email->toNative(),
            'password' => Hash::make($password)
        ]);
    }
}
