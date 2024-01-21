<?php

namespace Tests\Feature\User;

use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Modules\Shared\Bus\CommandBus;
use Modules\Shared\Services\IdService;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\ValueObjects\File;
use Modules\User\Application\Commands\CreateUserCommand;
use Modules\User\Application\Commands\EditUserProfileCommand;
use Tests\TestCase;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class EditUserProfileTest extends TestCase
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

        $this->userId = $this->idService->generate();
        $this->profileId = $this->idService->generate();

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
    }

    public function test_can_update(): void
    {
        $this->commandBus->dispatch(
            new EditUserProfileCommand(
                profileId: $this->profileId,
                nick: 'editnick',
                bio: null,
                picture: null
            )
        );

        $this->assertDatabaseHas('user_profiles', [
            'id' => $this->profileId->toNative(),
            'nick' => 'editnick',
            'bio' => 'Lorem impsum',
            'pictureId' => null
        ]);

        $this->commandBus->dispatch(
            new EditUserProfileCommand(
                profileId: $this->profileId,
                nick: 'editnick2',
                bio: 'bio',
                picture: null
            )
        );

        $this->assertDatabaseHas('user_profiles', [
            'id' => $this->profileId->toNative(),
            'nick' => 'editnick2',
            'bio' => 'bio',
            'pictureId' => null
        ]);
    }

    public function test_can_update_with_picture(): void
    {
        $fileContents = 'XXX';
        $fileName = 'example.png';
        $uploadedFile = UploadedFile::fake()->createWithContent($fileName, $fileContents);

        Storage::fake('local');
        $file = File::fromRequestFile($uploadedFile);

        $this->commandBus->dispatch(
            new EditUserProfileCommand(
                profileId: $this->profileId,
                nick: 'editnick',
                bio: null,
                picture: $file
            )
        );

        $profile = UserProfile::first();

        Storage::disk('local')->assertExists('profile-pictures/'.$profile->pictureId.'.png');

        $this->assertDatabaseHas('user_profiles', [
            'id' => $this->profileId->toNative(),
            'nick' => 'editnick',
            'bio' => 'Lorem impsum',
            'pictureId' => $profile->pictureId
        ]);

        $this->commandBus->dispatch(
            new EditUserProfileCommand(
                profileId: $this->profileId,
                nick: 'editnick',
                bio: null,
                picture: null
            )
        );
    }
}
