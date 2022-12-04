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
}
