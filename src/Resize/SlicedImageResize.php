<?php

namespace Antey\InstagramImage\Resize;

use Antey\ImageSlice\Exception\ImageSliceException;
use Antey\ImageSlice\HorizontalImageSlice;

class SlicedImageResize extends AbstractResize
{
    /**
     * @param string $path
     * @return array
     * @throws ImageSliceException
     */
    public function resize(string $path): array
    {
        $imageSlice = new HorizontalImageSlice(
            $this->imageResolution->getWidth(),
            $this->imageResolution->getHeight()
        );
        $imageSlice->allowUpscale();

        return $imageSlice->slice($this->image->getPath(), $path);
    }
}
