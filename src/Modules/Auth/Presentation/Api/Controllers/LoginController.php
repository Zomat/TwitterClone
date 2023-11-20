<?php declare(strict_types=1);

namespace Modules\Auth\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Application\Dtos\LoginUserDto;
use Modules\Auth\Application\Exceptions\AuthenticationException;
use Modules\Auth\Application\Services\LoginService;
use Modules\Auth\Presentation\Api\Requests\LoginUserRequest;

class LoginController extends Controller
{
    public function __construct(
        protected LoginService $service
    ) {}

    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        try {
            $token = $this->service->login(new LoginUserDto(
                email: $request->email,
                password: $request->password,
            ));
        } catch (AuthenticationException $e) {
            return response()->json(["message"=> "Bad credentials"], 401);
        }

        return response()->json([
            'token' => $token
        ], 201);
    }
}
