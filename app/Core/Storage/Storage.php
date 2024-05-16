<?php

namespace App\Core\Storage;

class Storage
{
    protected string $storagePath;

    public function __construct(string $storagePath = null)
    {
        $this->storagePath = self::joinPaths(storage_path(), $storagePath);
        $this->checkFolder($this->storagePath);
    }

    public function putToFile(string $fileName, string $content): void
    {
        file_put_contents($this->storagePath . DIRECTORY_SEPARATOR . $fileName, $content, FILE_APPEND | LOCK_EX);
    }

    public function checkFolder(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path);
        }
    }

    public static function joinPaths($basePath, $path = ''): string
    {
        return $basePath . ($path != '' ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }
}