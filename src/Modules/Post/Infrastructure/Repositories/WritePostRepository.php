<?php declare(strict_types=1);

namespace Modules\Post\Infrastructure\Repositories;

use Modules\Post\Domain\Repositories\IWritePostRepository;
use Modules\Shared\ValueObjects\Id;
use Illuminate\Support\Facades\DB;

final class WritePostRepository implements IWritePostRepository
{
    public function create(Id $id, Id $userId, string $content, \DateTimeImmutable $createdAt): void
    {
        DB::table('posts')->insert([
            'id' => $id->toNative(),
            'user_id'=> $userId->toNative(),
            'content'=> $content,
            'created_at'=> $createdAt->format('Y-m-d H:i:s'),
        ]);
    }
}
