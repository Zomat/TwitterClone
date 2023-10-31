<?php declare(strict_types=1);

namespace Modules\Auth\Queries;

use Modules\Auth\Repositories\IReadUserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

        if ($user !== null && Hash::check($query->password, $user->password)) {
            return $user;
        }

        return null;
    }
}
