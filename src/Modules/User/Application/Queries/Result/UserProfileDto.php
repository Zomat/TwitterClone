<?php declare(strict_types=1);

namespace Modules\User\Application\Queries\Result;

use Modules\Shared\ValueObjects\Id;

final readonly class UserProfileDto
{
    public function __construct(
        public readonly string $userId,
        public readonly string $profileId,
        public readonly string $nick,
        public readonly string $bio,
        public readonly ?string $picturePath,
        public readonly ?bool $followsAuthUser,
        public readonly ?bool $followedByAuthUser
    ) {}
}
