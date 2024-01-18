<?php declare(strict_types=1);

namespace Modules\User\Application\Dtos;

use Modules\Shared\ValueObjects\Id;

final class UserProfileDto
{
    public function __construct(
        public readonly Id $id,
        public readonly string $nick,
        public readonly string $bio,
        public readonly ?Id $pictureId,
    ) {}
}
