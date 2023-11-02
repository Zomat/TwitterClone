<?php declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use Modules\Auth\Commands\CreateUserCommand;
use Modules\Auth\Queries\FindUserQuery;
use Modules\Auth\Requests\RegisterUserRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Bus\QueryBus;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Email;

use App\Models\User;

class RegisterController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
        protected IdService $idService,
    ) {}

    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $id = $this->idService->generate();

        $this->commandBus->dispatch(
            new CreateUserCommand(
                id: $id,
                name: $request->name,
                email: Email::fromString($request->email),
                password: $request->password
            )
        );

        $user = $this->queryBus->ask(
            new FindUserQuery($id)
        );

        return response()->json([
            'id' => $user->getId(),
        ], 201);
    }
}
