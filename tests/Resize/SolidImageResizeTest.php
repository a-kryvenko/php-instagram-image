<?php

namespace Antey\InstagramImage\Resize;

use Antey\InstagramImage\Image\Image;
use Antey\InstagramImage\Resolution\SquareResolution;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\Resize\SolidImageResize
 * @covers \Antey\InstagramImage\Resize\AbstractResize
 * @uses \Antey\InstagramImage\Image\Image
 * @uses \Antey\InstagramImage\Resize\SolidImageResize
 * @uses \Antey\InstagramImage\Resolution\SquareResolution
 */
class SolidImageResizeTest extends TestCase
{
    public function testResizing(): void
    {
        $sourcePath = __DIR__ . '/testfile.jpeg';
        $destinationPath = __DIR__ . '/resultfile.jpeg';
        $width = 20;
        $height = 30;

        $imageResource = imagecreate($width, $height);
        imagejpeg($imageResource, $sourcePath, 100);

        $resolution = new SquareResolution();
        $image = new Image($sourcePath);

        $resize = new SolidImageResize(
            $image,
            $resolution
        );
        $resize->resize($destinationPath);

        $this->assertFileExists($destinationPath);
        $sizes = getimagesize($destinationPath);

        $this->assertEquals(
            $resolution->getWidth(),
            $sizes[0]
        );
        $this->assertEquals(
            $resolution->getHeight(),
            $sizes[1]
        );

        unlink($sourcePath);
        unlink($destinationPath);
    }
}
