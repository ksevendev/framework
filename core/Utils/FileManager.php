<?php

namespace Core\Utils;

use Illuminate\Filesystem\Filesystem;

class FileManager
{

    protected Filesystem $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    public function delete(string $filePath): bool
    {
        return $this->filesystem->exists($filePath) ? $this->filesystem->delete($filePath) : false;
    }

    public function getMimeType(string $filePath): string
    {
        return mime_content_type($filePath) ?: 'application/octet-stream';
    }

}
