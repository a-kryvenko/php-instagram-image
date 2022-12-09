<?php

namespace Antey\InstagramImage\Resize;

use Exception;
use Antey\ImageSlice\Exception\ImageSliceException;
use Antey\ImageSlice\HorizontalImageSlice;

class SlicedImageResize extends AbstractResize
{
    /**
     * @param string $path
     * @return array
     * @throws Exception
     */
    protected function save(string $path): array
    {
        $slicedPaths = [];
        try {
            $imageSlice = new HorizontalImageSlice(
                $this->imageResolution->getWidth(),
                $this->imageResolution->getHeight()
            );
            $imageSlice->allowUpscale();

            $slicedPaths = $imageSlice->slice($this->image->getPath(), $path);
            if (!empty($this->convertedFilePath)) {
                unlink($this->convertedFilePath);
            }
        } catch (Exception $e) {
            if (!empty($this->convertedFilePath)) {
                unlink($this->convertedFilePath);
            }
            throw $e;
        }

        return $slicedPaths;
    }
}
