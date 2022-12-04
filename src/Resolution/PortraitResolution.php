<?php

namespace Antey\InstagramImage\Resolution;

class PortraitResolution implements ImageResolutionInterface
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
        return 1350;
    }

    /**
     * @inheritDoc
     */
    public function getRatio(): float
    {
        return 0.8;
    }
}
