<?php declare(strict_types=1);

namespace Modules\Shared\Repositories\UserProfile;

use Modules\Shared\ValueObjects\Id;

interface IUserProfileRepository
{
    public function create(
        Id $id,
        Id $userId,
        string $nick,
        string $bio,
        ?Id $pictureId
    ): void;
}
