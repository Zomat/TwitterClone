<?php declare(strict_types=1);

namespace Modules\Auth\Application\Commands;

use Modules\Auth\Domain\Repositories\IWritePersonalAccessTokenRepository;
use Modules\Shared\Bus\CommandHandler;

class RevokeAllPersonalAccessTokenCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePersonalAccessTokenRepository $repository
    ) {}

    public function handle(RevokeAllPersonalAccessTokenCommand $command)
    {
        $this->repository->revokeAll(
           userId: $command->userId,
        );
    }
}
