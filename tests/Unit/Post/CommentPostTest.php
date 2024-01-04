<?php declare(strict_types=1);

namespace Tests\Unit\Post;

use Modules\Post\Domain\Post;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;

class CommentPostTest extends TestCase
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

    public function test_can_comment_post(): void
    {
         /* Given */
        $commentId = Id::fromString('123-comment-123');
        $userId = Id::fromString('123-user-id-123');
        $createdAt = new \DateTime;
        $content = "test content";

        /* When */
        $this->post->comment(
            commentId: $commentId,
            userId: $userId,
            content: $content,
            createdAt: $createdAt
        );

        /* Then */
        $this->assertEquals($this->post->getPayload()['comments'], [
            [
                'id' => $commentId->toNative(),
                'postId' => $this->postId->toNative(),
                'userId' => $userId->toNative(),
                'content' => $content,
                'createdAt' => $this->postCreatedAt->format(self::DATE_FORMAT)
            ]
        ]);
    }
}
