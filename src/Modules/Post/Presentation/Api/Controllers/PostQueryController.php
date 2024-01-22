<?php declare(strict_types=1);

namespace Modules\Post\Presentation\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Post\Application\Queries\IGetPostQuery;
use Modules\Shared\ValueObjects\Id;
use Illuminate\Http\Response;

class PostQueryController extends Controller
{
    public function getPost(string $postId, IGetPostQuery $query): JsonResponse
    {
        $post = $query->ask(Id::fromString($postId));

        if ($post === null) {
            return response()->json(['error' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($post);
    }
}
