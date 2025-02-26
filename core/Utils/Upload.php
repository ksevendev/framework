<?php

namespace Core\Utils;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Upload
{

    protected string $uploadPath;

    public function __construct(string $uploadPath = '/storage/uploads')
    {
        $this->uploadPath = realpath(__DIR__ . '/..') . $uploadPath;
    }

    public function upload(UploadedFile $file, string $folder = ''): string
    {
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $destination = rtrim($this->uploadPath, '/') . '/' . ltrim($folder, '/') . '/' . $filename;
        
        $file->move(dirname($destination), basename($destination));

        return str_replace(realpath(__DIR__ . '/..'), '', $destination);
    }

}

