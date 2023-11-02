<?php declare(strict_types=1);

namespace Modules\Auth\Services;

use Modules\Shared\Entities\User;
use Modules\Shared\Mappers\UserMapper;

use Illuminate\Support\Facades\Auth;

class SanctumAuthenticatedUserService implements IAuthenticatedUserService
{
    public function get(): ?User
    {
        return Auth::check() ? UserMapper::toEntity(Auth::user()) : null;
    }
}
