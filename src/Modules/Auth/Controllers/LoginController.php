<?php declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Commands\CreatePersonalAccessTokenCommand;
use Modules\Auth\Commands\RevokeAllPersonalAccessTokenCommand;
use Modules\Auth\Queries\LoginUserQuery;
use Modules\Auth\Requests\LoginUserRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Bus\QueryBus;
use Modules\Shared\ValueObjects\Email;

class LoginController extends Controller
{
    public function __construct(
        protected QueryBus $queryBus,
        protected CommandBus $commandBus,
    ) {}

    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $user = $this->queryBus->ask(
            new LoginUserQuery(Email::fromString($request->email), $request->password)
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
