<?php declare(strict_types=1);

namespace Modules\Auth\Services;

use Modules\Shared\Entities\User;

interface IAuthenticatedUserService
{
    public function get(): ?User;
}
