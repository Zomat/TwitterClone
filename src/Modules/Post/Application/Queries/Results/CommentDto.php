<?php declare(strict_types=1);

namespace Modules\Post\Application\Queries\Results;

final readonly class CommentDto
{
    public function __construct(
        public string $content,
        public string $createdAt,
        public string $creatorNick,
        public string $creatorProfileId,
        public ?string $creatorPicturePath,
    ) {}
}
