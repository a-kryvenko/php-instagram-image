<?php

namespace Antey\InstagramImage\Conformity;

use Antey\InstagramImage\Resolution\ImageResolutionInterface;
use Exception;

abstract class AbstractImageConformity
{
    /**
     * @param ImageResolutionInterface[] $imageSizes
     * @param int $width
     * @param int $height
     * @return ImageResolutionInterface
     * @throws Exception
     */
    public function getOptimalSize(array $imageSizes, int $width, int $height): ImageResolutionInterface
    {
        $maxConformity = -1;
        $selectedSize = null;

        foreach ($imageSizes as $imageSize) {
            $conformity = $this->getConformity(
                $imageSize->getWidth(),
                $imageSize->getHeight(),
                $width,
                $height
            );
            if ($conformity > $maxConformity) {
                $maxConformity = $conformity;
                $selectedSize = $imageSize;
            }
        }

        if (is_null($selectedSize)) {
            throw new Exception('Unsupported image resolution');
        }

        return $selectedSize;
    }

    /**
     * @param int $wishWidth
     * @param int $wishHeight
     * @param int $width
     * @param int $height
     * @return int
     */
    abstract public function getConformity(int $wishWidth, int $wishHeight, int $width, int $height): int;
}
