<?php declare(strict_types=1);

namespace Modules\Shared\Entities;

use Modules\Shared\ValueObjects\Id;

class UserProfile extends BaseEntity
{
    public function __construct(
        private Id $id,
        private Id $userId,
        private string $nick,
        private string $bio,
        private ?Id $pictureId
    ) {}

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }

    public function getNick(): string
    {
        return $this->nick;
    }

    public function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    public function getPictureId(): ?Id
    {
        return $this->pictureId;
    }

    public function setPictureId(?Id $pictureId): void
    {
        $this->pictureId = $pictureId;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toNative(),
            'userId' => $this->userId->toNative(),
            'nick' => $this->nick,
            'bio' => $this->bio,
            'pictureId' => $this->pictureId !== null ? $this->pictureId->toNative() : null,
        ];
    }
}
