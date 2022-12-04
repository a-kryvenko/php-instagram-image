<?php

namespace Antey\InstagramImage\Resize;

use Antey\InstagramImage\Image\Image;
use Antey\InstagramImage\Resolution\ImageResolutionInterface;

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

    abstract public function resize(string $path): array;

    public function getResolution(): ImageResolutionInterface
    {
        return $this->imageResolution;
    }
}
