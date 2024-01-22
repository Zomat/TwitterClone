<?php declare(strict_types=1);

namespace Modules\Post\Application\Queries\Results;

final readonly class SharedPostDto
{
    public function __construct(
        public string $shareId,
        public PostDto $post,
        public string $content,
        public string $sharerNick,
        public string $sharerProfileId
    ) {}
}
