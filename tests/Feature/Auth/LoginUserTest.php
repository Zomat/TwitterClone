<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Auth\Queries\LoginUserQuery;
use Modules\Shared\Bus\QueryBus;
use Modules\Shared\ValueObjects\Email;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_login_user(): void
    {
        $email = "test@example.com";

        User::factory()->create([
            "email" => $email,
            "password" => Hash::make('123456789')
        ]);

        $queryBus = app(QueryBus::class);

        $user = $queryBus->ask(
            new LoginUserQuery(
                email: Email::fromString($email),
                password: '123456789',
            )
        );

        $this->assertEquals($user->getEmail()->toNative(), $email);
    }

    public function test_user_email_not_found(): void
    {
        $email = "test@example.com";

        User::factory()->create([
            "email" => $email,
            "password" => Hash::make('123456789')
        ]);

        $queryBus = app(QueryBus::class);

        $user = $queryBus->ask(
            new LoginUserQuery(
                email: Email::fromString('test@example2.com'),
                password: '123456789',
            )
        );

        $this->assertNull($user);
    }

    public function test_user_password_not_match(): void
    {
        $email = "test@example.com";

        User::factory()->create([
            "email" => $email,
            "password" => Hash::make('123456789')
        ]);

        $queryBus = app(QueryBus::class);

        $user = $queryBus->ask(
            new LoginUserQuery(
                email: Email::fromString($email),
                password: '12345678910',
            )
        );

        $this->assertNull($user);
    }
}
