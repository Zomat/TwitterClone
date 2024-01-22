<?php

namespace Modules\Shared\Repositories\User;

use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\Entities\User;
use App\Models\User as EUser;

class EReadUserRepository implements IReadUserRepository
{
    public function find(Id $id): ?User
    {
        $userModel = EUser::where('id', $id->toNative())->first();

        if ($userModel === null) {
            return null;
        }

        return $this->mapUserModelToUserEntity($userModel);
    }

    public function findByEmail(Email $email): ?User
    {
        $userModel = EUser::where('email', $email->toNative())->first();

        if ($userModel === null) {
            return null;
        }

        return $this->mapUserModelToUserEntity($userModel);
    }

    public function follows(Id $followerId, Id $followedId): bool
    {
        return EUser::where('id', $followerId->toNative())->first()->follows->contains($followedId->toNative());
    }

    private function mapUserModelToUserEntity($userModel): User
    {
        return new User(
            id: Id::fromString($userModel->id),
            name: $userModel->name,
            email: Email::fromString($userModel->email),
            password: $userModel->password,
            emailVerifiedAt: $userModel->email_verified_at ? new \DateTime($userModel->email_verified_at) : null,
            rememberToken: $userModel->remember_token
        );
    }
}
