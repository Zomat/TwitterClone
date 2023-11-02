<?php declare(strict_types=1);

namespace Modules\Auth\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use Modules\Auth\Application\Commands\CreateUserCommand;
use Modules\Auth\Application\Queries\IFindUserQuery;
use Modules\Auth\Application\Requests\RegisterUserRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Email;

class RegisterController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IdService $idService,
        protected IFindUserQuery $findUserQuery,
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

        $user = $this->findUserQuery->ask(
            userId: $id
        );

        return response()->json([
            'id' => $user->getId(),
        ], 201);
    }
}
