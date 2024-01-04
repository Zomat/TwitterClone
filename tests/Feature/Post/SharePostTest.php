<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Post\Application\Commands\SharePostCommand;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;

class SharePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_share_post(): void
    {
        $commandBus = app(CommandBus::class);
        $date = new \DateTime;

        $commandBus->dispatch(
            new SharePostCommand(
                id: Id::fromString('123-test-123'),
                userId: Id::fromString('123-user-123'),
                postId: Id::fromString('123-post-123'),
                content: "Test content",
                createdAt: $date
            )
        );

        $this->assertDatabaseHas('post_shares', [
            'id' => '123-test-123',
            'user_id' => '123-user-123',
            'post_id' => '123-post-123',
            'content' => "Test content",
            'created_at' => $date
        ]);
    }
}
