<?php

namespace Antey\InstagramImage\Image;

use Antey\InstagramImage\Exception\FileNotFoundException;
use Antey\InstagramImage\Exception\WrongFileExtensionException;

class Image implements ImageInterface
{
    private string $path;
    private string $width;
    private string $height;

    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'webp', 'png'];

    /**
     * @param string $path
     * @throws FileNotFoundException
     * @throws WrongFileExtensionException
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException($path);
        }

        $extension = $this->getFileExtension($path);
        if (!$this->isAllowableExtension($extension)) {
            throw new WrongFileExtensionException($path);
        }

        $sizes = getimagesize($path);

        $this->path = $path;
        $this->extension = $extension;
        $this->width = $sizes[0];
        $this->height = $sizes[1];
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return string extension of given file
     */
    private function getFileExtension(string $path): string
    {
        $extension = '';

        $pathParts = explode('.', $path);
        if (count($pathParts) > 1) {
            $extension = $pathParts[count($pathParts) - 1];
        }

        return $extension;
    }

    /**
     * @param string $extension
     * @return bool
     * Check if given extension is one of allowed image extensions.
     */
    private function isAllowableExtension(string $extension): bool
    {
        return in_array($extension, self::ALLOWED_EXTENSIONS);
    }
}
