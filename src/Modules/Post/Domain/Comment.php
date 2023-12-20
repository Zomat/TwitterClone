<?php declare(strict_types=1);

namespace Modules\Post\Domain;

use Modules\Shared\Entities\BaseEntity;
use Modules\Shared\ValueObjects\Id;

final class Comment extends BaseEntity
{
    public function __construct(
        private Id $id,
        private Id $userId,
        private Id $postId,
        private string $content,
        private \DateTime $createdAt
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id->toNative(),
            'userId' => $this->userId->toNative(),
            'postId' => $this->postId->toNative(),
            'content' => $this->content,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s')
        ];
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }

    public function getPostId(): Id
    {
        return $this->postId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setId(Id $id): void
    {
        $this->id = $id;
    }

    public function setUserId(Id $userId): void
    {
        $this->userId = $userId;
    }

    public function setPostId(Id $postId): void
    {
        $this->postId = $postId;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
