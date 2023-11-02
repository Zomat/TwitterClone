<?php declare(strict_types=1);

namespace Modules\Auth\Application\Commands;

use Modules\Shared\Bus\CommandHandler;
use Modules\Shared\Repositories\User\IWriteUserRepository;

class CreateUserCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWriteUserRepository $repository
    ) {}

    public function handle(CreateUserCommand $command)
    {
        $this->repository->create(
            id: $command->id,
            name: $command->name,
            email: $command->email,
            password: $command->password
        );
    }
}
