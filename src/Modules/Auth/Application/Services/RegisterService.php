<?php declare(strict_types=1);

namespace Modules\Auth\Application\Services;

use Modules\Auth\Application\Commands\CreateUserCommand;
use Modules\Auth\Application\Dtos\RegisterUserDto;
use Modules\Auth\Application\Queries\IFindUserQuery;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\Entities\User;

final class RegisterService
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IdService $idService,
        protected IFindUserQuery $findUserQuery,
    ) {}

    public function register(RegisterUserDto $dto): User
    {
        $id = $this->idService->generate();

        $this->commandBus->dispatch(
            new CreateUserCommand(
                id: $id,
                name: $dto->name,
                email: Email::fromString($dto->email),
                password: $dto->password
            )
        );

        return $this->findUserQuery->ask(
            userId: $id
        );
    }
}
