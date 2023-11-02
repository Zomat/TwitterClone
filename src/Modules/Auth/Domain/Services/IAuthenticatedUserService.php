<?php declare(strict_types=1);

namespace Modules\Auth\Domain\Services;

use Modules\Shared\Entities\User;

interface IAuthenticatedUserService
{
    public function get(): ?User;
}
