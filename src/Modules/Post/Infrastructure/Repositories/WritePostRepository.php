<?php declare(strict_types=1);

namespace Modules\Post\Infrastructure\Repositories;

use Modules\Post\Domain\IWritePostRepository;
use Illuminate\Support\Facades\DB;
use Modules\Post\Domain\Post;
use App\Models\Post as EloquentPost;
use App\Models\PostLike as EloquentPostLike;

final class WritePostRepository implements IWritePostRepository
{
    const POST_LIKES_TABLE = 'post_likes';

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

        $eloquentPost = EloquentPost::where('id', $payload['id'])->with('likes')->firstOrFail();

        DB::transaction(function () use ($eloquentPost, $payload) {
            $eloquentPost->update([
                'content' => $payload['content'],
            ]);

            $this->syncLikes($eloquentPost, $payload['likes']);
        });
    }

    private function syncLikes(EloquentPost $post, array $likes): void
    {
        $existingLikes = $post->likes->pluck('id')->toArray();
        $newLikes = collect($likes)->pluck('id')->toArray();

        $likesToRemove = array_diff($existingLikes, $newLikes);
        $likesToAdd = array_diff($newLikes, $existingLikes);

        // Remove likes that are not present in the updated array
        EloquentPostLike::whereIn('id', $likesToRemove)->delete();

        // Add new likes
        foreach ($likes as $like) {
            if (in_array($like['id'], $likesToAdd)) {
                EloquentPostLike::create([
                    'id' => $like['id'],
                    'user_id' => $like['userId'],
                    'post_id' => $like['postId'],
                    'created_at' => $like['createdAt'],
                ]);
            }
        }
    }
}
