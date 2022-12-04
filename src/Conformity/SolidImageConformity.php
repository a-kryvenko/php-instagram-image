<?php

namespace Antey\InstagramImage\Conformity;

use Antey\InstagramImage\Resolution\ImageResolutionInterface;

class SolidImageConformity extends AbstractImageConformity
{
    public function getConformity(int $wishWidth, int $wishHeight, int $width, int $height): int
    {
        $wishAttitude = $wishWidth / $wishHeight;
        $attitude = $width / $height;

        $deviation = round(abs($attitude - $wishAttitude) / $wishAttitude, 2);
        $deviation = min(100, intval($deviation * 100));

        return min(100, 100 - $deviation);
    }
}
