<?php

namespace Antey\InstagramImage\Resize;

use Antey\InstagramImage\Image\Image;
use Antey\InstagramImage\Resolution\SquareResolution;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\Resize\SlicedImageResize
 * @uses \Antey\InstagramImage\Resize\AbstractResize
 * @uses \Antey\InstagramImage\Image\Image
 * @uses \Antey\InstagramImage\Resize\SolidImageResize
 * @uses \Antey\InstagramImage\Resolution\SquareResolution
 */
class SlicedImageResizeTest extends TestCase
{
    public function testResizing(): void
    {
        $sourcePath = __DIR__ . '/testfile.jpeg';
        $destinationPath = __DIR__ . '/';
        $width = 40;
        $height = 20;

        $imageResource = imagecreate($width, $height);
        imagejpeg($imageResource, $sourcePath, 100);

        $resolution = new SquareResolution();
        $image = new Image($sourcePath);

        $resize = new SlicedImageResize(
            $image,
            $resolution
        );
        $paths = $resize->resize($destinationPath);

        foreach ($paths as $path) {
            $this->assertFileExists($path);
            $sizes = getimagesize($path);

            $this->assertEquals(
                $resolution->getWidth(),
                $sizes[0]
            );
            $this->assertEquals(
                $resolution->getHeight(),
                $sizes[1]
            );
            unlink($path);
        }
        unlink($sourcePath);
    }
}
