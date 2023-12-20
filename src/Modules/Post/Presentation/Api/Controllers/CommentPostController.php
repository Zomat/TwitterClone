<?php declare(strict_types=1);

namespace Modules\Post\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Modules\Post\Application\Commands\CommentPostCommand;
use Modules\Post\Presentation\Api\Requests\CommentPostRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Id;

class CommentPostController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IAuthenticatedUserService $authenticationService,
        protected IdService $idService,
    ) {}

    public function __invoke(CommentPostRequest $request): JsonResponse
    {
        $user = $this->authenticationService->get();

        $commentId = $this->idService->generate();

        $this->commandBus->dispatch(
            new CommentPostCommand(
                id: $commentId,
                postId: Id::fromString($request->postId),
                userId: $user->getId(),
                content: $request->content,
                createdAt: Carbon::now()->toDateTime(),
            )
        );

        return response()->json([
            "message" => "Comment created",
            "postId" => $commentId->toNative()
        ], 200);
    }
}
