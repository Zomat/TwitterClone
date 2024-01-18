<?php declare(strict_types=1);

namespace Modules\User\Application\Queries;

use Modules\Shared\Repositories\User\IReadUserRepository;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\Bus\Query;
use Modules\Shared\Entities\User;

class LoginUserQuery extends Query implements ILoginUserQuery
{
    public function __construct(
        protected readonly IReadUserRepository $repository
    ) {}

    public function ask(Email $email, string $password): ?User
    {
        $user = $this->repository->findByEmail($email);

        if ($user !== null && $this->passwordHashMatches($password, $user->getPassword())) {
            return $user;
        }

        return null;
    }

    protected function passwordHashMatches(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}
