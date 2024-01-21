<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use Modules\User\Application\Commands\CreateUserCommand;
use Modules\User\Application\Commands\FollowUserCommand;
use Modules\User\Domain\UserAlreadyFollowedException;
use Tests\TestCase;

class FollowUserTest extends TestCase
{
    use RefreshDatabase;

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    protected Id $followId;
    protected Id $userId;
    protected Id $userToFollowId;
    protected Id $profileToFollowId;
    protected Id $profileId;
    protected \DateTimeImmutable $date;
    protected CommandBus $commandBus;
    protected IdService $idService;

    public function setUp(): void
    {
        parent::setUp();
        $this->date = Carbon::now()->toDateTimeImmutable();

        $this->commandBus = app(CommandBus::class);
        $this->idService = app(IdService::class);

        $this->followId = $this->idService->generate();
        $this->userId = $this->idService->generate();
        $this->userToFollowId = $this->idService->generate();
        $this->profileId = $this->idService->generate();
        $this->profileToFollowId = $this->idService->generate();

        $this->commandBus->dispatch(
            new CreateUserCommand(
                userId: $this->userId,
                name: 'John Doe',
                email: Email::fromString('test@example.com'),
                password: '123456789',
                profileId: $this->profileId,
                nick: 'testnick',
                bio: 'Lorem impsum',
                pictureId: null,
                picture: null
            )
        );

        $this->commandBus->dispatch(
            new CreateUserCommand(
                userId: $this->userToFollowId,
                name: 'John Follow',
                email: Email::fromString('test2@example.com'),
                password: '123456789',
                profileId: $this->profileToFollowId,
                nick: 'testnick2',
                bio: 'Lorem impsum2',
                pictureId: null,
                picture: null
            )
        );


    }
    public function test_can_follow(): void
    {
        $this->commandBus->dispatch(
            new FollowUserCommand(
                id: $this->followId,
                followerId: $this->userId,
                followedId: $this->userToFollowId,
                createdAt: $this->date,
            )
        );

        $this->assertDatabaseHas('follows', [
            'id' => $this->followId->toNative(),
            'follower_id' => $this->userId->toNative(),
            'followed_id' => $this->userToFollowId->toNative(),
            'created_at' => $this->date->format(self::DATE_FORMAT)
        ]);
    }

    public function test_cant_follow_twice(): void
    {
        $this->commandBus->dispatch(
            new FollowUserCommand(
                id: $this->followId,
                followerId: $this->userId,
                followedId: $this->userToFollowId,
                createdAt: $this->date,
            )
        );

        $this->expectException(UserAlreadyFollowedException::class);
        $this->commandBus->dispatch(
            new FollowUserCommand(
                id: $this->idService->generate(),
                followerId: $this->userId,
                followedId: $this->userToFollowId,
                createdAt: $this->date,
            )
        );

        $this->assertDatabaseHas('follows', [
            'id' => $this->followId->toNative(),
            'follower_id' => $this->userId->toNative(),
            'followed_id' => $this->userToFollowId->toNative(),
            'created_at' => $this->date->format(self::DATE_FORMAT)
        ]);

        $this->assertDatabaseCount('follows', 1);
    }
}
