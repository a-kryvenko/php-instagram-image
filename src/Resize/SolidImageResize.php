<?php

namespace Antey\InstagramImage\Resize;

use Gumlet\ImageResize;
use Gumlet\ImageResizeException;

class SolidImageResize extends AbstractResize
{
    /**
     * @param string $path
     * @return string[]
     * @throws ImageResizeException
     */
    protected function save(string $path): array
    {
        $imageResize = new ImageResize($this->image->getPath());
        $imageResize->crop(
            $this->imageResolution->getWidth(),
            $this->imageResolution->getHeight(),
            true
        );
        $imageResize->save($path);

        return [$path];
    }
}
