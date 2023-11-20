<?php declare(strict_types=1);

namespace Modules\Auth\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Shared\Bus\CommandBus;

class CreatePostController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {

    }
}
