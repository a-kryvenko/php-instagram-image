<?php

namespace Antey\InstagramImage\Conformity;

use Antey\InstagramImage\Resolution\ImageResolutionInterface;

class SlicedImageConformity extends AbstractImageConformity
{
    /**
     * @inheritDoc
     */
    public function getConformity(int $wishWidth, int $wishHeight, int $width, int $height): int
    {
        $attitude = $width / $height;
        $wishAttitude = $wishWidth / $wishHeight;

        $partsCount = floor($attitude / $wishAttitude);
        if ($partsCount == 0) {
            return 0;
        }

        $totalExpectedAttitude = $wishAttitude * $partsCount;

        $deviation = abs($attitude - $totalExpectedAttitude) / $totalExpectedAttitude;
        $deviation = $deviation / $partsCount;

        return min(100, 100 - ceil($deviation * 100));
    }
}
