<?php

namespace Antey\InstagramImage\Resolution;

interface ImageResolutionInterface
{
    /**
     * @return int image width in pixels.
     */
    public function getWidth(): int;

    /**
     * @return int image height in pixels.
     */
    public function getHeight(): int;
}
