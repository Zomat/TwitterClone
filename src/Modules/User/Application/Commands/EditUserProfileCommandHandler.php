<?php declare(strict_types=1);

namespace Modules\User\Application\Commands;

use Modules\Shared\Bus\CommandHandler;
use Modules\Shared\Repositories\IDatabaseTransactions;
use Modules\Shared\Services\INotificationService;
use Modules\User\Domain\UserProfileService;

class EditUserProfileCommandHandler extends CommandHandler
{
    public function __construct(
        private UserProfileService $profileService,
        private INotificationService $notificationService,
        private IDatabaseTransactions $databaseTransactions
    ) {}

    public function handle(EditUserProfileCommand $command): void
    {
        $this->databaseTransactions->beginTransaction();

        try {
            $this->profileService->edit(
                id: $command->profileId,
                nick: $command->nick,
                bio: $command->bio,
                picture: $command->picture
            );

           $this->databaseTransactions->commit();
        } catch (\Exception $e) {
            $this->databaseTransactions->rollback();
            throw $e;
        }
    }
}
