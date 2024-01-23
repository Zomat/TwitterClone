<?php

namespace Tests\Feature\Post;

use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Modules\Post\Application\Commands\SharePostCommand;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SharePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_share_post(): void
    {
        $commandBus = app(CommandBus::class);
        $date = Carbon::now()->toDateTime();

        Post::factory()->create([
            'id' => "123-post-123",
            'user_id'=> "123-user-123",
            'content'=> "Test content",
            'created_at'=> $date,
        ]);

        User::factory()->create([
            "id" => "123-shared-by-123",
            "email" => "john.doe@example.com",
            "password" => Hash::make('123456789')
        ]);

        UserProfile::create([
            "id" => "123-profile-123",
            "user_id" => "123-shared-by-123",
            "nick" => "nickk",
            "bio" => "bio"
        ]);

        $commandBus->dispatch(
            new SharePostCommand(
                id: Id::fromString('123-test-123'),
                userId: Id::fromString('123-shared-by-123'),
                postId: Id::fromString('123-post-123'),
                content: "Test content",
                createdAt: $date
            )
        );

        $this->assertDatabaseHas('post_shares', [
            'id' => '123-test-123',
            'user_id' => '123-shared-by-123',
            'post_id' => '123-post-123',
            'content' => "Test content",
            'created_at' => $date
        ]);
    }
}
