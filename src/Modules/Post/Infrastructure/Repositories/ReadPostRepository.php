<?php declare(strict_types=1);

namespace Modules\Post\Infrastructure\Repositories;

use Modules\Post\Domain\IReadPostRepository;
use Illuminate\Support\Facades\DB;
use Modules\Post\Domain\Like;
use Modules\Post\Domain\Post;
use Modules\Post\Domain\Comment;
use Modules\Shared\ValueObjects\Id;
use App\Models\Post as EloquentPost;

final class ReadPostRepository implements IReadPostRepository
{
    public function findById(Id $id): Post
    {
        $postModel = EloquentPost::where('id', $id->toNative())->with('likes')->first();

        if ($postModel == null) {
            throw new \Exception('Post does not exist');
        }

        return self::map($postModel);
    }

    private static function map(EloquentPost $postModel): Post
    {
        $likes = $postModel->likes;
        $likesEntites = [];

        foreach ($likes as $like) {
            $likesEntites[] = new Like(
                id: Id::fromString($like->id),
                userId: Id::fromString($like->user_id),
                postId: Id::fromString($like->post_id),
                createdAt: new \DateTime($like->created_at),
            );
        }

        $comments = $postModel->comments;
        $commentsEntites = [];

        foreach ($comments as $comment) {
            $commentsEntites[] = new Comment(
                id: Id::fromString($comment->id),
                userId: Id::fromString($comment->user_id),
                postId: Id::fromString($comment->post_id),
                content: $comment->content,
                createdAt: new \DateTime($comment->created_at),
            );
        }

        $post = new Post;
        $post->load(
            id: Id::fromString($postModel->id),
            userId: Id::fromString($postModel->user_id),
            content: $postModel->content,
            createdAt: $postModel->created_at->toDateTimeImmutable(),
            likes: $likesEntites,
            comments: $commentsEntites
        );

        return $post;
    }
}
