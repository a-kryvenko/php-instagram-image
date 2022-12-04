<?php

namespace Antey\InstagramImage\Resolution;

class IGTVCoverResolution implements ImageResolutionInterface
{
    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return 420;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return 654;
    }
}
