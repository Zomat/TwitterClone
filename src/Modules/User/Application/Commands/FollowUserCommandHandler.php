<?php declare(strict_types=1);

namespace Modules\User\Application\Commands;

use Modules\Shared\Bus\CommandHandler;
use Modules\Shared\Repositories\IDatabaseTransactions;
use Modules\Shared\Services\INotificationService;
use Modules\User\Domain\UserService;

class FollowUserCommandHandler extends CommandHandler
{
    public function __construct(
        private UserService $userService,
        private INotificationService $notificationService,
        private IDatabaseTransactions $databaseTransactions
    ) {}

    public function handle(FollowUserCommand $command): void
    {
        $this->databaseTransactions->beginTransaction();

        try {
            $this->userService->follow(
                followId: $command->id,
                followerId: $command->followerId,
                followedId: $command->followedId,
                createdAt: $command->createdAt,
            );

           $this->notificationService->sendUserFollowedNotification($command->followerId, $command->followedId);

           $this->databaseTransactions->commit();
        } catch (\Exception $e) {
            $this->databaseTransactions->rollback();
            throw $e;
        }
    }
}
