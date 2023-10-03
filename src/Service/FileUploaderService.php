<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    /**
     * @var Filesystem $filesystem
     */
    private Filesystem $filesystem;

    /**
     * @var string $uploadsDirectory
     */
    private string $uploadsDirectory;

    /**
     * @param Filesystem $filesystem
     * @param string $uploadsDirectory
     */
    public function __construct(Filesystem $filesystem, string $uploadsDirectory)
    {
        $this->filesystem = $filesystem;
        $this->uploadsDirectory = $uploadsDirectory;
    }

    /**
     * @param UploadedFile $file
     * @param string|null $folder
     * @param string|null $filename
     * @param bool|null $uniqueId
     * @return string
     */
    public function upload(UploadedFile $file, ?string $folder, ?string $filename, ?bool $uniqueId = true): string
    {
        if($uniqueId) {
            $filename = $filename . uniqid();
        }
        $originalFilename = $filename ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalFilename . '.' . $file->guessExtension();
        $fullDir = $this->uploadsDirectory . '/' . $folder;
        if(!file_exists($fullDir)) {
            mkdir($fullDir, 0777, true);
        }
        $file->move($fullDir, $fileName);

        return $folder . $fileName;
    }

    /**
     * @param string $filename
     * @return void
     */
    public function remove(string $filename): void
    {
        $fullPath = $this->uploadsDirectory . '/' . $filename;

        if($this->filesystem->exists($fullPath)) {
            $this->filesystem->remove($fullPath);
            $this->removeEmptyParentDirectories(dirname($fullPath));
        }
    }

    private function removeEmptyParentDirectories(string $directory): void
    {
        if($directory === $this->uploadsDirectory) {
            return;
        }

        if(count(scandir($directory)) === 2) {
            rmdir($directory);
            $this->removeEmptyParentDirectories(dirname($directory));
        }
    }

    public function copy(string $originalFilename, ?string $folder, ?string $filename, ?bool $uniqueId = true): string
    {
        $fullPath = $this->uploadsDirectory . '/';

        if($uniqueId) {
            $filename = $filename . uniqid();
        }
        $filename .= '.' . pathinfo($originalFilename, PATHINFO_EXTENSION);

        if($this->filesystem->exists($fullPath . $originalFilename)) {
            $this->filesystem->copy($fullPath . $originalFilename, $fullPath . $folder . $filename);
        }

        return $folder . $filename;
    }
}
