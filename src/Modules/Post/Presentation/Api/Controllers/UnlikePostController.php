<?php declare(strict_types=1);

namespace Modules\Post\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Post\Application\Commands\UnlikePostCommand;
use Modules\Post\Presentation\Api\Requests\UnlikePostRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;

class UnlikePostController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IAuthenticatedUserService $authenticationService,
        protected IdService $idService,
    ) {}

    public function __invoke(UnlikePostRequest $request): JsonResponse
    {
        $user = $this->authenticationService->get();

        try {
            $this->commandBus->dispatch(
                new UnlikePostCommand(
                    userId: $user->getId(),
                    postId: Id::fromString($request->postId)
                )
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            "message" => "Post unliked",
        ], 201);
    }
}
