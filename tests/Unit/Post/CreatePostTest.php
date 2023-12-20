<?php

namespace Tests\Unit\Post;

use Modules\Post\Domain\Post;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;


class CreatePostTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_can_create_post(): void
    {
        $idMock = Id::fromString('123-321');
        $userIdMock = Id::fromString('321-123');
        $createdAtMock = new \DateTimeImmutable();

        $post = new Post;
        $post->create(
            $idMock,
            $userIdMock,
            'Test content',
            $createdAtMock,
        );

       $this->assertEquals($post->getPayload(), [
            'id' => $idMock->toNative(),
            'userId' => $userIdMock->toNative(),
            'content' => 'Test content',
            'createdAt' => $createdAtMock->format('Y-m-d H:i:s'),
            'likes' => [],
            'comments' => []
       ]);
    }
}
