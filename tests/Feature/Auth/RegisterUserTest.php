<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Auth\Commands\CreateUserCommand;
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
                id: Id::fromString('123-test-123'),
                name: 'John Doe',
                email: Email::fromString('test@example.com'),
                password: '123456789',
            )
        );

        $this->assertDatabaseHas('users', [
            'id'=> '123-test-123',
            'name' => 'John Doe',
        ]);
    }
}
