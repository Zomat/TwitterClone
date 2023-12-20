<?php

namespace Tests\Unit\Post;

use Modules\Post\Domain\Post;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;

class LoadPostTest extends TestCase
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

    public function test_can_load_post(): void
    {
        $idMock = Id::fromString('123-321');
        $userIdMock = Id::fromString('321-123');
        $createdAtMock = new \DateTimeImmutable();

        $post = new Post;
        $post->load(
            $idMock,
            $userIdMock,
            'Test content',
            $createdAtMock,
            [],
            []
        );

         $likeId = Id::fromString('123-like-123');
         $userId = Id::fromString('123-user-id-123');
         $createdAt = new \DateTime;

         $post->like(
             likeId: $likeId,
             userId: $userId,
             createdAt: $createdAt
         );

        $this->assertEquals($post->getPayload(), [
                'id' => $idMock->toNative(),
                'userId' => $userIdMock->toNative(),
                'content' => 'Test content',
                'createdAt' => $createdAtMock->format('Y-m-d H:i:s'),
                'likes' => [
                    [
                        "id" => "123-like-123",
                        "postId" => "123-321",
                        "userId" => "123-user-id-123",
                        "createdAt" => $createdAt->format('Y-m-d H:i:s')
                    ]
                ],
                'comments' => []
        ]);
    }
}
