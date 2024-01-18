<?php declare(strict_types=1);

namespace Modules\User\Application\Commands;

use Modules\Shared\Bus\CommandHandler;
use Modules\Shared\Repositories\User\IWriteUserRepository;
use Modules\Shared\Repositories\UserProfile\IUserProfileRepository;
use Modules\Shared\Services\IdService;
use Modules\Shared\Services\IFileService;

class CreateUserCommandHandler extends CommandHandler
{
    public function __construct(
        protected IWriteUserRepository $userRepository,
        protected IUserProfileRepository $userProfileRepository,
        protected IdService $idService,
        protected IFileService $fileService,
    ) {}

    public function handle(CreateUserCommand $command)
    {
        $this->userRepository->beginTransaction();

        try {
            $this->userRepository->create(
                id: $command->userId,
                name: $command->name,
                email: $command->email,
                password: $command->password
            );

            $this->userProfileRepository->create(
                id: $command->profileId,
                userId: $command->userId,
                nick: $command->nick,
                bio: $command->bio,
                pictureId: $command->pictureId,
            );

            if (! is_null($command->picture)) {
                $this->fileService->store(
                    path: 'profile-pictures/'.$command->pictureId->toNative().'.'.$command->picture->extension,
                    file: $command->picture
                );
            }

            $this->userRepository->commit();
        } catch (\Exception $e) {
            $this->userRepository->rollback();
            throw $e;
        }

    }
}
