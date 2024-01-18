<?php declare(strict_types=1);

namespace Modules\User\Application\Queries;

use Modules\Shared\Bus\Query;
use Modules\Shared\Repositories\User\IReadUserRepository;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\Entities\User;

class FindUserQuery extends Query implements IFindUserQuery
{
    public function __construct(
        protected readonly IReadUserRepository $repository
    ) {}

    public function ask(Id $userId): ?User
    {
        return $this->repository->find(
            $userId
        );
    }
}
