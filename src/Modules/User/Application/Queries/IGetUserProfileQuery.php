<?php declare(strict_types=1);

namespace Modules\User\Application\Queries;

use Modules\User\Application\Queries\Result\UserProfileDto;
use Modules\Shared\ValueObjects\Id;

interface IGetUserProfileQuery
{
    public function ask(Id $profileId): ?UserProfileDto;
}
