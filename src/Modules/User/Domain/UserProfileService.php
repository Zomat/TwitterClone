<?php declare(strict_types=1);

namespace Modules\User\Domain;

use Modules\Shared\Repositories\UserProfile\IUserProfileRepository;
use Modules\Shared\Services\IdService;
use Modules\Shared\Services\IFileService;
use Modules\Shared\ValueObjects\Id;
use Modules\Shared\ValueObjects\File;

class UserProfileService
{
    private const PICTURES_DIR = 'profile-pictures/';

    public function __construct(
        private IUserProfileRepository $repository,
        private IdService $idService,
        private IFileService $fileService
    ) {}

    public function edit(Id $id, ?string $nick, ?string $bio, ?File $picture): void
    {
        // Check if profil exists
        $profile = $this->repository->find($id);

        $oldPictureId = $profile->getPictureId();

        $newPictureId = is_null($picture) ? null : $this->idService->generate();

        // Picture logic
        if (! is_null($picture)) {
            $this->fileService->store(
                path: self::PICTURES_DIR.$newPictureId->toNative().'.'.$picture->extension,
                file: $picture
            );

            if (! is_null($oldPictureId)) {
                $oldPicture = $this->fileService->getByFilename(
                    directory: self::PICTURES_DIR,
                    fileNameWithoutExtension: $oldPictureId->toNative()
                );

                if (! is_null($oldPicture)) {
                    $this->fileService->delete(
                        filePath: self::PICTURES_DIR.$oldPictureId->toNative().'.'.$oldPicture->extension,
                    );
                }
            }
        }

        $this->repository->edit(
            id: $id,
            nick: $nick,
            bio: $bio,
            pictureId: $newPictureId
        );
    }
}
