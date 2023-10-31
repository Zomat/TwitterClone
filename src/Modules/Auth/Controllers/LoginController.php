<?php declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use Modules\Auth\Queries\LoginUserQuery;
use Modules\Auth\Requests\LoginUserRequest;

use App\Models\User;

class RegisterController extends Controller
{
    public function __construct(
        protected QueryBus $queryBus,
    ) {}

    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $user = $this->queryBus->ask(
            new LoginUserQuery($request->email, $request->password)
        );

        if ($user === null) {
            return response()->json(["message"=> "Bad credentials"], 401);
        }

        $userModel = User::where('id', $user->id)->first();

        return response()->json([
            'token' =>  $userModel->createToken('apiToken')->plainTextToken
        ], 201);
    }
}
