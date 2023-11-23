<?php declare(strict_types=1);

namespace Modules\Post\Application\Dtos;

final class CreatePostDto
{
    public function __construct(
        public readonly string $content,
    ) {}
}
