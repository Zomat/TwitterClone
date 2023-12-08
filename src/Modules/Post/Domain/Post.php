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

    private ?array $likes;

    public function create(Id $id, Id $userId, string $content, \DateTimeImmutable $createdAt): void
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->content = $content;
        $this->createdAt = $createdAt;

        $this->likes = null;
    }

    public function load(Id $id, Id $userId, string $content, \DateTimeImmutable $createdAt, ?array $likes): void
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->likes = $likes;
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->id->toNative(),
            'userId' => $this->userId->toNative(),
            'content' => $this->content,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'likes' => $this->likes ?? null
        ];
    }
}
