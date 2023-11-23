<?php declare(strict_types=1);

namespace Modules\Post\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Modules\Post\Application\Commands\CreatePostCommand;
use Modules\Post\Application\Dtos\CreatePostDto;
use Modules\Post\Presentation\Api\Requests\CreatePostRequest;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;

class CreatePostController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IAuthenticatedUserService $authenticationService,
        protected IdService $idService,
    ) {}

    public function __invoke(CreatePostRequest $request): JsonResponse
    {
        $dto = new CreatePostDto(
            content: $request->content,
        );

        $user = $this->authenticationService->get();

        $postId = $this->idService->generate();

        $this->commandBus->dispatch(
            new CreatePostCommand(
                id: $postId,
                userId: $user->getId(),
                content: $request->content,
                createdAt: Carbon::now()->toDateTimeImmutable(),
            )
        );

        return response()->json($this->authenticationService->get()->toArray(), 200);
    }
}
