<?php declare(strict_types=1);

namespace Modules\Post\Domain;

use Modules\Shared\Entities\BaseEntity;

use Modules\Shared\ValueObjects\Id;

final class Like extends BaseEntity
{
    public function __construct(
        private Id $id,
        private Id $postId,
        private Id $userId,
        private \DateTime $createdAt,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id->toNative(),
            'postId' => $this->postId->toNative(),
            'userId' => $this->userId->toNative(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s')
        ];
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getPostId(): Id
    {
        return $this->postId;
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setId(Id $id): void
    {
        $this->id = $id;
    }

    public function setPostId(Id $postId): void
    {
        $this->postId = $postId;
    }

    public function setUserId(Id $userId): void
    {
        $this->userId = $userId;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
