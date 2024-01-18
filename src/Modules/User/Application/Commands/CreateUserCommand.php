<?php declare(strict_types=1);

namespace Modules\User\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\ValueObjects\Email;
use Modules\Shared\ValueObjects\File;

class CreateUserCommand extends Command
{
    public function __construct(
        public readonly Id $userId,
        public readonly string $name,
        public readonly Email $email,
        public readonly string $password,
        public readonly Id $profileId,
        public readonly string $nick,
        public readonly string $bio,
        public readonly ?Id $pictureId,
        public readonly ?File $picture
    ) {}
}
