<?php declare(strict_types=1);

namespace Modules\User\Application\Commands;

use Modules\Shared\Bus\Command;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\ValueObjects\File;

class EditUserProfileCommand extends Command
{
    public function __construct(
        public readonly Id $profileId,
        public readonly ?string $nick,
        public readonly ?string $bio,
        public readonly ?File $picture
    ) {}
}
