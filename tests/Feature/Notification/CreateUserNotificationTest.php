<?php

namespace Tests\Feature\Notification;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Shared\Enums\NotificationType;
use Modules\Shared\Services\INotificationService;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected INotificationService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(INotificationService::class);
    }

    public function test_can_create_post_liked_notification(): void
    {
        User::factory()->create([
            "id" => "123-liked-by-123",
            "email" => "john.doe@example.com",
            "password" => Hash::make('123456789')
        ]);

        $this->service->sendPostLikedNotification(Id::fromString('123-user-123'), Id::fromString('123-liked-by-123'));

        $this->assertDatabaseHas('notifications', [
            'user_id' => '123-user-123',
            'type' => NotificationType::POST_LIKED
        ]);
    }

    public function test_can_create_post_shared_notification(): void
    {
        User::factory()->create([
            "id" => "123-shared-by-123",
            "email" => "john.doe@example.com",
            "password" => Hash::make('123456789')
        ]);

        $this->service->sendPostSharedNotification(Id::fromString('123-user-123'), Id::fromString('123-shared-by-123'));

        $this->assertDatabaseHas('notifications', [
            'user_id' => '123-user-123',
            'type' => NotificationType::POST_SHARED
        ]);
    }
}
