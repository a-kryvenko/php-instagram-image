<?php

namespace Antey\InstagramImage\Resolution;

class ProfileResolution implements ImageResolutionInterface
{
    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return 360;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return 360;
    }

    /**
     * @inheritDoc
     */
    public function getRatio(): float
    {
        return 1.0;
    }
}
