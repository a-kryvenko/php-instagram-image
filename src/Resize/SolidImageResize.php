<?php

namespace Antey\InstagramImage\Resize;

use Gumlet\ImageResize;

class SolidImageResize extends AbstractResize
{
    public function resize(string $path): array
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
