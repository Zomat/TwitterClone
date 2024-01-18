<?php declare(strict_types=1);

namespace Modules\User\Application\Services;

use Modules\User\Application\Commands\CreateUserCommand;
use Modules\User\Application\Dtos\UserDto;
use Modules\User\Application\Dtos\UserProfileDto;
use Modules\User\Application\Queries\IFindUserQuery;
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

    public function register(UserDto $userDto, UserProfileDto $profileDto): User
    {
        $id = $this->idService->generate();

        $this->commandBus->dispatch(
            new CreateUserCommand(
                $userDto,
                $profileDto
            )
        );

        return $this->findUserQuery->ask(
            userId: $id
        );
    }
}
