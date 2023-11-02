<?php declare(strict_types=1);

namespace Modules\Auth\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Application\Commands\CreatePersonalAccessTokenCommand;
use Modules\Auth\Application\Commands\RevokeAllPersonalAccessTokenCommand;
use Modules\Auth\Application\Queries\ILoginUserQuery;
use Modules\Auth\Application\Requests\LoginUserRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\ValueObjects\Email;

class LoginController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected ILoginUserQuery $loginUserQuery,
    ) {}

    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $user = $this->loginUserQuery->ask(
            email: Email::fromString($request->email),
            password: $request->password
        );

        if ($user === null) {
            return response()->json(["message"=> "Bad credentials"], 401);
        }

        $this->commandBus->dispatch(
            new RevokeAllPersonalAccessTokenCommand($user->getId())
        );

        $token = sprintf(
            '%s%s%s',
            '',
            $tokenEntropy = bin2hex(random_bytes(20)),
            hash('crc32b', $tokenEntropy)
        );

        $this->commandBus->dispatch(
            new CreatePersonalAccessTokenCommand($user->getId(), $token)
        );

        return response()->json([
            'token' => $token
        ], 201);
    }
}
