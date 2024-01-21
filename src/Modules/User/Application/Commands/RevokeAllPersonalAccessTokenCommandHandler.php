<?php declare(strict_types=1);

namespace Modules\User\Application\Commands;

use Modules\User\Domain\IWritePersonalAccessTokenRepository;
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
