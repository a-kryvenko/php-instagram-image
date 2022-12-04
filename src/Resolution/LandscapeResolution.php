<?php

namespace Antey\InstagramImage\Resolution;

class LandscapeResolution implements ImageResolutionInterface
{
    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return 1080;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return 565;
    }
}
