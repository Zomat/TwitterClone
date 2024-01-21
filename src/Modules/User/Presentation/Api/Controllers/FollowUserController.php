<?php declare(strict_types=1);

namespace Modules\User\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Id;
use Modules\User\Application\Commands\FollowUserCommand;
use Modules\User\Domain\CannotFollowYourselfException;
use Modules\User\Domain\UserAlreadyFollowedException;
use Modules\User\Presentation\Api\Requests\FollowUserRequest;

class FollowUserController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IAuthenticatedUserService $authenticationService,
        protected IdService $idService,
    ) {}

    public function __invoke(FollowUserRequest $request): JsonResponse
    {
        try {
            $followId = $this->idService->generate();
            $this->commandBus->dispatch(
                new FollowUserCommand(
                    id: $followId,
                    followerId: $this->authenticationService->get()->getId(),
                    followedId: Id::fromString($request->userId),
                    createdAt: Carbon::now()->toDateTimeImmutable()
                )
            );
        } catch (UserAlreadyFollowedException|CannotFollowYourselfException $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(["error" => "Unexcepted error"], 500);
        }

        return response()->json([
            'follow_id' => $followId->toNative()
        ], 201);
    }
}
