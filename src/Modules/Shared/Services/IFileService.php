<?php declare(strict_types=1);

namespace Modules\Shared\Services;

use Modules\Shared\ValueObjects\File;

interface IFileService
{
    public function store(string $path, File $file): void;

    public function delete(string $filePath): void;

    public function getByFilename(string $directory, string $fileNameWithoutExtension): ?File;
}
