<?php declare(strict_types=1);

namespace Modules\User\Application\Queries\Result;

use Modules\Shared\ValueObjects\Id;

final readonly class UserProfileDto
{
    public function __construct(
        public string $userId,
        public string $profileId,
        public string $nick,
        public string $bio,
        public ?string $picturePath,
        public ?bool $followsAuthUser,
        public ?bool $followedByAuthUser
    ) {}
}
