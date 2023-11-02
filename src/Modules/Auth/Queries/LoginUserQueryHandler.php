<?php declare(strict_types=1);

namespace Modules\Auth\Queries;

use Modules\Shared\Repositories\User\IReadUserRepository;
use Illuminate\Support\Facades\Hash;

class LoginUserQueryHandler
{
    public function __construct(
        protected readonly IReadUserRepository $repository
    ) {}

    public function handle(LoginUserQuery $query): ?object
    {
        $user = $this->repository->findByEmail(
            $query->email
        );

        if ($user !== null && Hash::check($query->password, $user->getPassword())) {
            return $user;
        }

        return null;
    }
}
