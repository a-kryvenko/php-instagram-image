<?php

namespace Antey\InstagramImage\Resize;

use Antey\InstagramImage\Image\Image;
use Antey\InstagramImage\Resolution\ImageResolutionInterface;
use Exception;
use Gumlet\ImageResize;

abstract class AbstractResize
{
    protected Image $image;
    protected ImageResolutionInterface $imageResolution;

    public function __construct(
        Image $image,
        ImageResolutionInterface $imageResolution
    )
    {
        $this->imageResolution = $imageResolution;
        $this->image = $image;
    }

    /**
     * @param string $path
     * @return array
     * @throws Exception
     */
    public function resize(string $path = ''): array
    {
        $this->convertImage();
        return $this->save($path ?: $this->image->getPath());
    }

    /**
     * @param string $path
     * @return array
     * @throws Exception
     */
    abstract protected function save(string $path): array;

    /**
     * @return ImageResolutionInterface
     */
    public function getResolution(): ImageResolutionInterface
    {
        return $this->imageResolution;
    }

    /**
     * @return void
     * @throws Exception
     */
    private function convertImage(): void
    {
        $pathParts = explode('/', $this->image->getPath());
        $name = $pathParts[count($pathParts) - 1];

        $nameParts = explode('.', $name);
        $extension = $nameParts[count($nameParts) - 1];

        if (in_array($extension, ['jpeg', 'jpg'])) {
            return;
        }

        $newName = str_replace('.'.$extension, '.jpeg', $name);
        $path = str_replace('/' . $name, '/' . $newName, $this->image->getPath());

        $imageResize = new ImageResize($this->image->getPath());
        $imageResize->save($path, IMAGETYPE_JPEG);

        $this->image = new Image($path);
    }
}
