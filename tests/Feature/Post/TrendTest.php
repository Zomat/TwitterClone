<?php

namespace Tests\Feature\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Modules\Post\Application\Commands\CreatePostCommand;
use Modules\Post\Application\Commands\SharePostCommand;
use Modules\Post\Domain\TrendService;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TrendTest extends TestCase
{
    use RefreshDatabase;

    public function test_trend_created(): void
    {
        $commandBus = app(CommandBus::class);

        $commandBus->dispatch(
            new CreatePostCommand(
                id: Id::fromString('id-123-123'),
                userId: Id::fromString('user-id-123'),
                content: 'Test content with #mytrend',
                createdAt: Carbon::now()->toDateTimeImmutable(),
            )
        );

        $this->assertDatabaseHas('trends', [
            'name' => 'mytrend',
            'times_used' => 1
        ]);

        $commandBus->dispatch(
            new CreatePostCommand(
                id: Id::fromString('id-123-1234'),
                userId: Id::fromString('user-id-123'),
                content: 'Test content with #mytrend #databases',
                createdAt: Carbon::now()->toDateTimeImmutable(),
            )
        );

        $this->assertDatabaseHas('trends', [
            'name' => 'mytrend',
            'times_used' => 2
        ]);

        $this->assertDatabaseHas('trends', [
            'name' => 'databases',
            'times_used' => 1
        ]);
    }
}
