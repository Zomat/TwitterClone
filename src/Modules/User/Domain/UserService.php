<?php declare(strict_types=1);

namespace Modules\User\Domain;

use Modules\Shared\Repositories\User\IReadUserRepository;
use Modules\Shared\Repositories\User\IWriteUserRepository;
use Modules\Shared\ValueObjects\Id;

class UserService
{
    public function __construct(
        protected IWriteUserRepository $userWriteRepository,
        protected IReadUserRepository $userReadRepository,
    ) {}

    public function follow(Id $followId, Id $followerId, Id $followedId, \DateTimeImmutable $createdAt): void
    {
        if ($this->userReadRepository->follows($followerId, $followedId)) {
            throw new UserAlreadyFollowedException;
        }

        if ($followerId->equals($followedId)) {
            throw new CannotFollowYourselfException;
        }

        $this->userWriteRepository->follow(
            id: $followId,
            followerId: $followerId,
            followedId: $followedId,
            createdAt: $createdAt,
        );
    }
}
