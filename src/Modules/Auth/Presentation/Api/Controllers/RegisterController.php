<?php declare(strict_types=1);

namespace Modules\Auth\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Application\Dtos\RegisterUserDto;
use Modules\Auth\Application\Services\RegisterService;
use Modules\Auth\Presentation\Api\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    public function __construct(
        protected RegisterService $service,
    ) {}

    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->service->register(new RegisterUserDto(
            name: $request->name,
            email: $request->email,
            password: $request->password,
        ));

        return response()->json([
            'id' => $user->getId()->toNative(),
        ], 201);
    }
}
