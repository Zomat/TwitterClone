<?php

namespace Tests\Feature\Auth;

use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\User\Application\Commands\CreateUserCommand;
use Modules\User\Application\Dtos\UserDto;
use Modules\User\Application\Dtos\UserProfileDto;
use Modules\User\Application\Queries\IFindUserQuery;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_register_user(): void
    {
        $commandBus = app(CommandBus::class);

        $commandBus->dispatch(
            new CreateUserCommand(
                userId: Id::fromString('123-test-123'),
                name: 'John Doe',
                email: Email::fromString('test@example.com'),
                password: '123456789',
                profileId: Id::fromString('123-profile-123'),
                nick: 'testnick',
                bio: 'Lorem impsum',
                pictureId: null,
                picture: null
            )
        );

        $this->assertDatabaseHas('users', [
            'id'=> '123-test-123',
            'name' => 'John Doe',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'id' => '123-profile-123',
            'user_id'=> '123-test-123',
            'nick' => 'testnick',
            'bio' => 'Lorem impsum',
            'picture_id' => null
        ]);
    }

    public function test_create_user_and_profile_is_atomic(): void
    {
        $commandBus = app(CommandBus::class);

        $commandBus->dispatch(
            new CreateUserCommand(
                userId: Id::fromString('123-test-123'),
                name: 'John Doe',
                email: Email::fromString('test@example.com'),
                password: '123456789',
                profileId: Id::fromString('123-profile-123'),
                nick: 'testnick',
                bio: 'Lorem impsum',
                pictureId: null,
                picture: null
            )
        );


        // $this->assertDatabaseHas('users', [
        //     'id'=> '123-test-123',
        //     'name' => 'John Doe',
        // ]);

        $this->assertDatabaseHas('user_profiles', [
            'id' => '123-profile-123',
            'user_id'=> '123-test-123',
            'nick' => 'testnick',
            'bio' => 'Lorem impsum',
            'picture_id' => null
        ]);
    }
}
