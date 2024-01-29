<?php declare(strict_types=1);

namespace Modules\Post\Infrastructure\Queries;

use App\Models\Post;
use Modules\Post\Application\Queries\IGetPostQuery;
use Modules\Post\Application\Queries\Results\CommentDto;
use Modules\Post\Application\Queries\Results\PostDto;
use Modules\Shared\Services\IFileService;
use Modules\Shared\ValueObjects\Id;
use Modules\User\Application\Queries\IGetUserProfileQuery;

final class GetPostQuery implements IGetPostQuery
{
    public function __construct(
        private IFileService $fileService,
        private IGetUserProfileQuery $userProfileQuery
    ) {}

    public function ask(Id $id): ?PostDto
    {
        $post = Post::with(['likes', 'comments', 'shares'])->where('id', $id->toNative())->first();

        if ($post === null) {
            return null;
        }

        $authUser = auth('sanctum')->user();

        if ($authUser !== null) {
            $likedByAuthUser = $post->likes->where('user_id', $authUser->id)->first()?->exists();
        }

        $comments = [];
        foreach ($post->comments->sortBy('created_at') as $comment) {
            $profile = $comment->user->profile()->first();
            if ($profile->picture_id !== null) {
                $picture = $this->fileService->getByFilename('profile-pictures/', $profile->picture_id);
            }

            $comments[] = new CommentDto(
                content: $comment->content,
                creatorNick: $profile->nick,
                creatorProfileId: $profile->id,
                creatorPicturePath: isset($picture) ? $picture->fullpath : null,
                createdAt: (new \DateTimeImmutable($comment->created_at))->format('Y-m-d H:i:s')
            );
        }

        return new PostDto(
            id: $id->toNative(),
            creatorProfile: $this->userProfileQuery->ask(Id::fromString($post->user->profile->id)),
            content: $post->content,
            createdAt: (new \DateTimeImmutable($post->created_at))->format('Y-m-d H:i:s'),
            likesCount: $post->likes->count(),
            likedByAuthUser: $likedByAuthUser ?? null,
            comments: $comments,
            commentsCount: count($comments),
            sharesCount: $post->shares->count()
        );
    }
}
