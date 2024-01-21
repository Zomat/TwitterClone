<?php declare(strict_types=1);

namespace Modules\Shared\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Shared\ValueObjects\File;

class StorageFileService implements IFileService
{
    public function store(string $path, File $file): void
    {
        Storage::put($path, file_get_contents($file->fullpath));
    }

    public function delete(string $filePath): void
    {
        Storage::delete($filePath);
    }

    public function getByFilename(string $directory, string $fileNameWithoutExtension): ?File
    {
        $files = Storage::files($directory);

        foreach ($files as $file) {
            $pathinfo = pathinfo($file);

            if ($pathinfo['filename'] === $fileNameWithoutExtension) {
                return File::fromPath($pathinfo['basename']);
            }
        }

        return null;
    }
}
