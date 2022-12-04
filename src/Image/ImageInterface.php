<?php

namespace Antey\InstagramImage\Image;

interface ImageInterface
{
    /**
     * @return int width of image in pixels
     */
    public function getWidth(): int;

    /**
     * @return int height of image in pixels
     */
    public function getHeight(): int;

    /**
     * @return string absolute path of image
     */
    public function getPath(): string;
}
