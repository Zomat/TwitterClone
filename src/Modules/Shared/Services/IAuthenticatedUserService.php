<?php declare(strict_types=1);

namespace Modules\Shared\Services;

use Modules\Shared\Entities\User;

interface IAuthenticatedUserService
{
    public function get(): ?User;
}
