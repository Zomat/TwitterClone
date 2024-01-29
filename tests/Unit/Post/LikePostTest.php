<?php declare(strict_types=1);

namespace Tests\Unit\Post;

use Modules\Post\Domain\Post;
use Modules\Post\Domain\PostAlreadyLikedException;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;

class LikePostTest extends TestCase
{
    private Post $post;

    private Id $postId;
    private Id $postUserId;
    private \DateTimeImmutable $postCreatedAt;

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    protected function setUp(): void
    {
        parent::setUp();

        $this->postId = Id::fromString('123-321');
        $this->postUserId = Id::fromString('321-123');
        $this->postCreatedAt = new \DateTimeImmutable();

        $this->post = new Post;
        $this->post->create(
            $this->postId,
            $this->postUserId,
            'Test content',
            $this->postCreatedAt,
        );
    }

    public function test_can_like_post(): void
    {
         /* Given */
        $likeId = Id::fromString('123-like-123');
        $userId = Id::fromString('123-user-id-123');
        $createdAt = new \DateTime;

        /* When */
        $this->post->like(
            likeId: $likeId,
            userId: $userId,
            createdAt: $createdAt
        );

        /* Then */
        $this->assertEquals($this->post->getPayload()['likes'], [
            [
                'id' => $likeId->toNative(),
                'postId' => $this->postId->toNative(),
                'userId' => $userId->toNative(),
                'createdAt' => $this->postCreatedAt->format(self::DATE_FORMAT)
            ]
        ]);
    }

    public function test_can_unlike_post(): void
    {
         /* Given */
        $likeId = Id::fromString('123-like-123');
        $userId = Id::fromString('123-user-id-123');
        $createdAt = new \DateTime;

        /* When */
        $this->post->like(
            likeId: $likeId,
            userId: $userId,
            createdAt: $createdAt
        );

        /* Then */
        $this->assertEquals($this->post->getPayload()['likes'], [
            [
                'id' => $likeId->toNative(),
                'postId' => $this->postId->toNative(),
                'userId' => $userId->toNative(),
                'createdAt' => $this->postCreatedAt->format(self::DATE_FORMAT)
            ]
        ]);

        /* When */
        $this->post->unlike(
            userId: $userId
        );

        /* Then */
        $this->assertEquals(0, count($this->post->getPayload()['likes']));
    }

    public function test_if_same_user_cant_like_post_twice(): void
    {
         /* Given */
        $likeId = Id::fromString('123-like-123');
        $likeId2 = Id::fromString('123-like-123-2');
        $userId = Id::fromString('123-user-id-123');
        $createdAt = new \DateTime;
        $createdAt2 = new \DateTime($createdAt->format(self::DATE_FORMAT));

        /* When */
        $this->post->like(
            likeId: $likeId,
            userId: $userId,
            createdAt: $createdAt
        );

        $this->expectException(PostAlreadyLikedException::class);
        $this->post->like(
            likeId: $likeId2,
            userId: $userId,
            createdAt: $createdAt2->add(new \DateInterval('P1D'))
        );

        /* Then */
        $this->assertEquals($this->post->getPayload()['likes'], [
            [
                'id' => $likeId->toNative(),
                'postId' => $this->postId->toNative(),
                'userId' => $userId->toNative(),
                'createdAt' => $createdAt->format(self::DATE_FORMAT)
            ]
        ]);
    }

    public function test_if_other_user_can_like_post(): void
    {
         /* Given */
        $likeId = Id::fromString('123-like-123');
        $likeId2 = Id::fromString('123-like-123-2');
        $userId = Id::fromString('123-user-id-123');
        $userId2 = Id::fromString('123-user-id-123-2');
        $createdAt = new \DateTime;
        $createdAt2 = new \DateTime($createdAt->format(self::DATE_FORMAT));

        /* When */
        $this->post->like(
            likeId: $likeId,
            userId: $userId,
            createdAt: $createdAt
        );

        $this->post->like(
            likeId: $likeId2,
            userId: $userId2,
            createdAt: $createdAt2->add(new \DateInterval('P1D'))
        );

        /* Then */
        $this->assertEquals($this->post->getPayload()['likes'], [
            [
                'id' => $likeId->toNative(),
                'postId' => $this->postId->toNative(),
                'userId' => $userId->toNative(),
                'createdAt' => $createdAt->format(self::DATE_FORMAT)
            ],
            [
                'id' => $likeId2->toNative(),
                'postId' => $this->postId->toNative(),
                'userId' => $userId2->toNative(),
                'createdAt' => $createdAt2->format(self::DATE_FORMAT)
            ],
        ]);
    }
}
