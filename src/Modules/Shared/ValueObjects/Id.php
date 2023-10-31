<?php declare(strict_types=1);

namespace Modules\Shared\ValueObjects;

class Id
{
    public function __construct(
        protected readonly string $id
    ) {}

    public static function fromString(string $id): Id
    {
        return new self($id);
    }

    public function toNative(): string
    {
        return $this->id;
    }
}
