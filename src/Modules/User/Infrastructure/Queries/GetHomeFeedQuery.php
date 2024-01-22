<?php declare(strict_types=1);

namespace Modules\User\Infrastructure\Queries;

use App\Models\Post;
use App\Models\User;
use App\Models\UserProfile;
use Modules\Post\Application\Queries\Results\CommentDto;
use Modules\Post\Application\Queries\Results\PostDto;
use Modules\Post\Application\Queries\Results\SharedPostDto;
use Modules\Shared\Services\IFileService;
use Modules\Shared\ValueObjects\Id;
use Modules\User\Application\Queries\IGetHomeFeedQuery;
use Modules\User\Application\Queries\IGetUserProfileQuery;

final class GetHomeFeedQuery implements IGetHomeFeedQuery
{
    public function __construct(
        private IFileService $fileService,
        private IGetUserProfileQuery $userProfileQuery
    ) {}

    public function ask(Id $userId, int $batch): array
    {
        $result = [];
        $user = User::with(['follows.posts', 'follows.shares'])->where('id', $userId->toNative())->first();

        $feed = collect();

        foreach ($user->follows as $follow) {
            $feed = $feed->merge($follow->posts->merge($follow->shares));
        }

        $feed->sortByDesc('created_at')->values()->all();

        foreach ($feed as $post) {
            $comments = [];

            $likedByAuthUser = $post->likes->where('user_id', $user->id)->first()?->exists() ?? false;

            foreach ($post->comments as $comment) {
                $profile = $comment->user->profile->first();

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

            $dto = new PostDto(
                id: $post->id,
                creatorProfile: $this->userProfileQuery->ask(Id::fromString($post->user->profile->id)),
                content: $post->content,
                createdAt: (new \DateTimeImmutable($post->created_at))->format('Y-m-d H:i:s'),
                likesCount: $post->likes->count(),
                likedByAuthUser: $likedByAuthUser ?? null,
                comments: $comments,
                commentsCount: count($comments),
                sharesCount: $post->shares->count()
            );

            if ($post->pivot !== null) {
                $sharerProfile = UserProfile::where('user_id', $post->pivot->user_id)->first();
                $dto = new SharedPostDto(
                    shareId: $post->pivot->id,
                    post: $dto,
                    content: $post->pivot->content,
                    sharerNick: $sharerProfile->nick,
                    sharerProfileId: $sharerProfile->id
                );
            }

            $result[] = $dto;
        }

        return $result;
    }
}
