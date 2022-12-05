<?php

namespace Antey\InstagramImage\Resize;

use Antey\InstagramImage\Image\Image;
use Antey\InstagramImage\Resolution\SquareResolution;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\Resize\AbstractResize
 * @uses \Antey\InstagramImage\Image\Image
 * @uses \Antey\InstagramImage\Resize\SolidImageResize
 */
class AbstractResizeTest extends TestCase
{
    public function testResolutionProviding(): void
    {
        $resolution = new SquareResolution();
        $image = $this->createMock(Image::class);
        $image->method('getWidth')
            ->willReturn(100);
        $image->method('getHeight')
            ->willReturn(200);

        $resize = new SolidImageResize(
            $image,
            $resolution
        );

        $this->assertEquals(
            $resolution,
            $resize->getResolution()
        );
    }

    public function testImageConverting(): void
    {
        $sourcePath = __DIR__ . '/testfile.webp';
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
