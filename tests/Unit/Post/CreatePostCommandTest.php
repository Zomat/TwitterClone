<?php

namespace Tests\Unit\Post;

use Modules\Post\Application\Commands\CreatePostCommand;
use Modules\Post\Application\Commands\CreatePostCommandHandler;
use Modules\Post\Domain\Repositories\IWritePostRepository;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;


class CreatePostCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_can_create_post(): void
    {
        $idMock = \Mockery::mock(Id::class);
        $userIdMock = \Mockery::mock(Id::class);
        $createdAtMock = new \DateTimeImmutable();

        $repositoryMock = \Mockery::mock(IWritePostRepository::class);
        $repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($idMock, $userIdMock, 'Test Content', $createdAtMock);

        $handler = new CreatePostCommandHandler($repositoryMock);

        $command = new CreatePostCommand(
            id: $idMock,
            userId: $userIdMock,
            content: 'Test Content',
            createdAt: $createdAtMock
        );

        $handler->handle($command);

        $repositoryMock->shouldHaveReceived('create')->once();
    }
}
