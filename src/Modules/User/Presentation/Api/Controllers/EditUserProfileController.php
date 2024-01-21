<?php declare(strict_types=1);

namespace Modules\User\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Repositories\UserProfile\IUserProfileRepository;
use Modules\Shared\Services\IAuthenticatedUserService;
use Modules\Shared\Services\IdService;
use Modules\User\Application\Commands\EditUserProfileCommand;
use Modules\User\Presentation\Api\Requests\EditUserProfileRequest;
use Modules\User\Presentation\Api\Requests\RegisterUserRequest;
use Modules\Shared\ValueObjects\File;

class EditUserProfileController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected IdService $idService,
        protected IAuthenticatedUserService $authService,
        protected IUserProfileRepository $profileRepository
    ) {}

    public function __invoke(EditUserProfileRequest $request): JsonResponse
    {
        $user = $this->authService->get();
        $userProfile = $this->profileRepository->findByUserId($user->getId());

        $this->commandBus->dispatch(
           new EditUserProfileCommand(
                profileId: $userProfile->getId(),
                nick: $request?->nick,
                bio: $request->bio,
                picture: is_null($request?->picture) ? null : File::fromRequestFile($request->picture)
           )
        );

        return response()->json([
            'message' => 'Profile updated!'
        ], 200);
    }
}
