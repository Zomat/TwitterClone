<?php declare(strict_types=1);

namespace Modules\User\Infrastructure\Repositories;

use App\Models\PersonalAccessToken;
use Modules\User\Domain\Repositories\IWritePersonalAccessTokenRepository;
use Modules\Shared\ValueObjects\Id;
use App\Models\User as EloquentUser;

class WritePersonalAccessTokenRepository implements IWritePersonalAccessTokenRepository
{
    public function create(
        Id $userId,
        string $token,
        array $abilities = ['*'],
        \DateTimeInterface $expiresAt = null
    ): void
    {
        $userModel = EloquentUser::where('id', $userId->toNative())->first();

        if ($userModel === null) {
            return;
        }

        $userModel->tokens()->create([
            'name' => $userModel->name,
            'token' => hash('sha256', $token),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);
    }

    public function revokeAll(Id $userId): void
    {
        $tokens = PersonalAccessToken::where('tokenable_id', $userId->toNative())->get();

        \DB::transaction(function () use ($tokens) {
            foreach ($tokens as $token) {
                $token->delete();
            }
        });
    }
}

