<?php

namespace Antey\InstagramImage\Resize;

use Exception;
use Gumlet\ImageResize;
use Gumlet\ImageResizeException;

class SolidImageResize extends AbstractResize
{
    /**
     * @param string $path
     * @return string[]
     * @throws Exception
     */
    protected function save(string $path): array
    {
        try {
            $imageResize = new ImageResize($this->image->getPath());
            $imageResize->crop(
                $this->imageResolution->getWidth(),
                $this->imageResolution->getHeight(),
                true
            );
            $imageResize->save($path);
        } catch (Exception $e) {
            if (!empty($this->convertedFilePath)) {
                unlink($this->convertedFilePath);
            }
            throw $e;
        }

        if (
            !empty($this->convertedFilePath)
            && $this->convertedFilePath != $path
        ) {
            unlink($this->convertedFilePath);
        }

        return [$path];
    }
}
