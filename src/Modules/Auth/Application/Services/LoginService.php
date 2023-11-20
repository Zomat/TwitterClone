<?php declare(strict_types=1);

namespace Modules\Auth\Application\Services;

use Illuminate\Auth\AuthenticationException;
use Modules\Auth\Application\Commands\CreatePersonalAccessTokenCommand;
use Modules\Auth\Application\Commands\RevokeAllPersonalAccessTokenCommand;
use Modules\Auth\Application\Dtos\LoginUserDto;
use Modules\Auth\Application\Queries\ILoginUserQuery;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\ValueObjects\Email;

final class LoginService
{
    public function __construct(
        private ILoginUserQuery $loginUserQuery,
        private CommandBus $commandBus
    ) {}

    public function login(LoginUserDto $dto): string
    {
        $user = $this->loginUserQuery->ask(
            email: Email::fromString($dto->email),
            password: $dto->password
        );

        if ($user === null) {
            throw new AuthenticationException("Bad credentials");
        }

        $this->commandBus->dispatch(
            new RevokeAllPersonalAccessTokenCommand($user->getId())
        );

        $token = $this->createToken();

        $this->commandBus->dispatch(
            new CreatePersonalAccessTokenCommand($user->getId(), $token)
        );

        return $token;
    }

    private function createToken(): string
    {
        return sprintf(
            '%s%s%s',
            '',
            $tokenEntropy = bin2hex(random_bytes(20)),
            hash('crc32b', $tokenEntropy)
        );
    }
}
