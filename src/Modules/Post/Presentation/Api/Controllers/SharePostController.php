<?php declare(strict_types=1);

namespace Modules\Post\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Modules\Post\Application\Commands\SharePostCommand;
use Modules\Post\Presentation\Api\Requests\SharePostRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Id;

class SharePostController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IAuthenticatedUserService $authenticationService,
        protected IdService $idService,
    ) {}

    public function __invoke(SharePostRequest $request): JsonResponse
    {
        $user = $this->authenticationService->get();

        $shareId = $this->idService->generate();

        $this->commandBus->dispatch(
            new SharePostCommand(
                id: $shareId,
                postId: Id::fromString($request->postId),
                userId: $user->getId(),
                content: $request->content,
                createdAt: Carbon::now()->toDateTime(),
            )
        );

        return response()->json([
            "message" => "Share created",
            "shareId" => $shareId->toNative()
        ], 201);
    }
}
