<?php declare(strict_types=1);

namespace Modules\Post\Domain;

use Modules\Shared\AggregateRoot;
use Modules\Shared\ValueObjects\Id;

final class Post extends AggregateRoot
{
    private Id $id;

    private Id $userId;

    private string $content;

    private \DateTimeImmutable $createdAt;

    private array $likes;

    private array $comments;

    public function create(Id $id, Id $userId, string $content, \DateTimeImmutable $createdAt): void
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->content = $content;
        $this->createdAt = $createdAt;

        $this->likes = [];
        $this->comments = [];
    }

    public function load(Id $id, Id $userId, string $content, \DateTimeImmutable $createdAt, array $likes, array $comments): void
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->likes = $likes;
        $this->comments = $comments;
    }

    public function isLikedByUser(Id $userId): bool
    {
        foreach ($this->likes as $like) {
            if ($like->getUserId()->equals($userId)) {
                return true;
            }
        }

        return false;
    }

    public function like(Id $likeId, Id $userId, \DateTime $createdAt): void
    {
        // User can't like post twice
        if ($this->isLikedByUser($userId)) {
            throw new PostAlreadyLikedException('Post has already been liked by the user.');
        }

        $this->likes[] = new Like(
            id: $likeId,
            postId: $this->id,
            userId: $userId,
            createdAt: $createdAt
        );
    }

    public function comment(Id $commentId, Id $userId, string $content, \DateTime $createdAt): void
    {
        $this->comments[] = new Comment(
            id: $commentId,
            userId: $userId,
            postId: $this->id,
            content: $content,
            createdAt: $createdAt
        );
    }

    public function getPayload(): array
    {
        $nativeLikes = array_map(fn (Like $like) => $like->toArray(), $this->likes);
        $nativeComments = array_map(fn (Comment $comment) => $comment->toArray(), $this->comments);

        return [
            'id' => $this->id->toNative(),
            'userId' => $this->userId->toNative(),
            'content' => $this->content,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'likes' => $nativeLikes,
            'comments' => $nativeComments
        ];
    }
}
