<?php declare(strict_types=1);

namespace Modules\User\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IdService;
use Modules\User\Application\Commands\CreateUserCommand;
use Modules\User\Application\Services\RegisterService;
use Modules\User\Presentation\Api\Requests\RegisterUserRequest;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\File;

class RegisterController extends Controller
{
    public function __construct(
        protected RegisterService $service,
        protected CommandBus $commandBus,
        protected IdService $idService
    ) {}

    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $userId = $this->idService->generate();
        $profileId = $this->idService->generate();
        $pictureId = $request->hasFile('picture') ? $this->idService->generate() : null;

        $this->commandBus->dispatch(
            new CreateUserCommand(
                userId: $userId,
                name: $request->name,
                email: Email::fromString($request->email),
                password: $request->password,
                profileId: $profileId,
                nick: $request->nick,
                bio: $request->bio,
                pictureId: $pictureId,
                picture: $request->hasFile('picture') ? File::fromRequestFile($request->file('picture')) : null
            )
        );

        return response()->json([
            'user_id' => $userId->toNative(),
            'user_profile_id' => $profileId->toNative(),
        ], 201);
    }
}
