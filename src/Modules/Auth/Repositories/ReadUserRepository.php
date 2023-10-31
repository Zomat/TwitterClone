<?php declare(strict_types=1);

namespace Modules\Auth\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;

class ReadUserRepository implements IReadUserRepository
{
    public function find(Id $id): ?object
    {
        return DB::table('users')->where('id', $id->toNative())->first();
    }

    public function findByEmail(Email $email): ?object
    {
        return DB::table('users')->where('emial', $email->toNative())->first();
    }
}
