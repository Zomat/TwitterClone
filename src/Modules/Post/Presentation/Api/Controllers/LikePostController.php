<?php declare(strict_types=1);

namespace Modules\Post\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Modules\Post\Application\Commands\LikePostCommand;
use Modules\Post\Presentation\Api\Requests\LikePostRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Id;

class LikePostController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IAuthenticatedUserService $authenticationService,
        protected IdService $idService,
    ) {}

    public function __invoke(LikePostRequest $request): JsonResponse
    {
        $user = $this->authenticationService->get();

        $likeId = $this->idService->generate();

        $this->commandBus->dispatch(
            new LikePostCommand(
                id: $likeId,
                userId: $user->getId(),
                postId: Id::fromString($request->postId),
                createdAt: Carbon::now()->toDateTimeImmutable(),
            )
        );

        return response()->json([
            "message" => "Post liked",
            "likeId" => $likeId->toNative()
        ], 200);
    }
}
