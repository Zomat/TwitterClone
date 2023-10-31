<?php declare(strict_types=1);

namespace Modules\Auth\Commands;

use App\Bus\CommandHandler;
use Modules\Auth\Repositories\IWriteUserRepository;

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
