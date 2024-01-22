<?php declare(strict_types=1);

namespace Modules\Shared\ValueObjects;

class File
{
    public function __construct(
        public readonly ?string $originalName,
        public readonly string $extension,
        public readonly string $path,
        public readonly string $filename,
        public readonly string $fullpath,
        public readonly string $basename,
        public readonly int $size
    ) {}

    public static function fromRequestFile(mixed $file): File
    {
        $ext = explode('/', $file->getClientMimeType())[1];
        $pathname = $file->getPath() . '/' . $file->getFilename();

        return new self(
            originalName: $file->getClientOriginalName(),
            extension: $ext,
            path: $file->getPath(),
            filename: $file->getFilename(),
            fullpath: $pathname,
            basename: $file->getBasename().'.'.$ext,
            size: $file->getSize()
        );
    }

    public static function fromPath(string $path)
    {
        $pathinfo = pathinfo($path);

        return new self(
            originalName: null,
            extension: $pathinfo['extension'],
            path: $pathinfo['dirname'],
            filename: $pathinfo['filename'],
            fullpath: $pathinfo['dirname'].'/'.$pathinfo['basename'],
            basename: $pathinfo['basename'],
            size: filesize($path)
        );
    }
}
