<?php declare(strict_types=1);

namespace Modules\Post\Infrastructure\Repositories;

use Modules\Post\Domain\IWritePostRepository;
use Illuminate\Support\Facades\DB;
use Modules\Post\Domain\Post;

final class WritePostRepository implements IWritePostRepository
{
    public function create(Post $post): void
    {
        $payload = $post->getPayload();

        DB::table('posts')->insert([
            'id' => $payload['id'],
            'user_id'=> $payload['userId'],
            'content'=> $payload['content'],
            'created_at'=> $payload['createdAt'],
        ]);
    }

    public function update(Post $post): void
    {
        $payload = $post->getPayload();

        DB::transaction(function () use ($payload) {
            DB::table('posts')->insert([
                'id' => $payload['id'],
                'user_id'=> $payload['userId'],
                'content'=> $payload['content'],
                'created_at'=> $payload['createdAt'],
            ]);

            foreach ($payload['likes'] as $like) {
                DB::table('post_likes')->where('id', $like['id'])->get();
            }
        });
    }
}
