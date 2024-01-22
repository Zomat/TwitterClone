<?php declare(strict_types=1);

namespace Modules\Post\Application\Queries\Results;
use Modules\User\Application\Queries\Result\UserProfileDto;

final readonly class PostDto
{
    /** @param CommentDto[] $comments $ */
    public function __construct(
        public string $id,
        public UserProfileDto $creatorProfile,
        public string $content,
        public string $createdAt,
        public int $likesCount,
        public ?bool $likedByAuthUser,
        public array $comments,
        public int $commentsCount,
        public int $sharesCount
    ) {}
}
