<?php declare(strict_types=1);

namespace Modules\Auth\Application\Commands;

use Modules\Auth\Domain\Repositories\IWritePersonalAccessTokenRepository;
use Modules\Shared\Bus\CommandHandler;

class CreatePersonalAccessTokenCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWritePersonalAccessTokenRepository $repository
    ) {}

    public function handle(CreatePersonalAccessTokenCommand $command)
    {
        $this->repository->create(
           userId: $command->userId,
           token: $command->token,
        );
    }
}
