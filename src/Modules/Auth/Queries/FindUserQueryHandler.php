<?php declare(strict_types=1);

namespace Modules\Auth\Queries;

use Modules\Auth\Repositories\IReadUserRepository;

class FindUserQueryHandler
{
    public function __construct(
        protected readonly IReadUserRepository $repository
    ) {}

    public function handle(FindUserQuery $query): ?object
    {
        return $this->repository->find(
            $query->id
        );
    }
}
