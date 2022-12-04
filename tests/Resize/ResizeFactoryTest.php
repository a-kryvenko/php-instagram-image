<?php

namespace Antey\InstagramImage\Resize;

use Antey\InstagramImage\Conformity\SlicedImageConformity;
use Antey\InstagramImage\Conformity\SolidImageConformity;
use Antey\InstagramImage\Exception\FileNotFoundException;
use Antey\InstagramImage\Exception\InstagramImageException;
use Antey\InstagramImage\Image\Image;
use Antey\InstagramImage\Resolution\LandscapeResolution;
use Antey\InstagramImage\Resolution\PortraitResolution;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\Resize\ResizeFactory
 * @uses \Antey\InstagramImage\Image\Image
 * @uses \Antey\InstagramImage\Resize\AbstractResize
 * @uses \Antey\InstagramImage\Resize\SolidImageResize
 * @uses \Antey\InstagramImage\Resize\SlicedImageResize
 * @uses \Antey\InstagramImage\Exception\FileNotFoundException
 */
class ResizeFactoryTest extends TestCase
{
    public function testConstructorWithoutParameters()
    {
        $this->expectException(FileNotFoundException::class);

        $resizeFactory = new ResizeFactory();
        $resizeFactory->getSingle('', []);

    }

    public function testGetSingle()
    {
        $this->expectException(FileNotFoundException::class);

        $resizeFactory = new ResizeFactory();
        $resizeFactory->getSingle('', []);
    }

    public function testGetSingleImageResizeNoResolution()
    {
        $this->expectException(InstagramImageException::class);

        $resizeFactory = new ResizeFactory();

        $resizeFactory->getSingleImageResize($this->getImageMock(), []);
    }

    public function testGetSingleImageResizeOneResolution()
    {
        $portraitResolution = new PortraitResolution();
        $solidImageConformity = $this->createMock(SolidImageConformity::class);
        $solidImageConformity->expects($this->never())
            ->method('getOptimalSize');

        $resizeFactory = new ResizeFactory($solidImageConformity);
        $resizer = $resizeFactory->getSingleImageResize(
            $this->getImageMock(),
            [$portraitResolution]
        );

        $this->assertEquals(
            SolidImageResize::class,
            get_class($resizer)
        );
        $this->assertEquals(
            $portraitResolution,
            $resizer->getResolution()
        );
    }

    public function testGetSingleImageResizeMultipleResolutions()
    {
        $image = $this->getImageMock();
        $portraitResolution = new PortraitResolution();
        $landscapeResolution = new LandscapeResolution();
        $solidImageConformity = $this->createMock(SolidImageConformity::class);
        $solidImageConformity->expects($this->once())
            ->method('getOptimalSize')
            ->with(
                [$portraitResolution, $landscapeResolution],
                $image->getWidth(),
                $image->getHeight()
            )
            ->willReturn($landscapeResolution);

        $resizeFactory = new ResizeFactory($solidImageConformity);
        $resizer = $resizeFactory->getSingleImageResize(
            $this->getImageMock(),
            [$portraitResolution, $landscapeResolution]
        );

        $this->assertEquals(
            SolidImageResize::class,
            get_class($resizer)
        );
        $this->assertEquals(
            $landscapeResolution,
            $resizer->getResolution()
        );
    }

    public function testGetSliced()
    {
        $this->expectException(FileNotFoundException::class);

        $resizeFactory = new ResizeFactory();
        $resizeFactory->getSliced('', []);
    }

    public function testGetSlicedImageResizeNoResolution()
    {
        $this->expectException(InstagramImageException::class);

        $resizeFactory = new ResizeFactory();

        $resizeFactory->getSlicedImageResize($this->getImageMock(), []);
    }

    public function testGetSlicedImageResizeOneResolution()
    {
        $portraitResolution = new PortraitResolution();
        $slicedImageConformity = $this->createMock(SlicedImageConformity::class);
        $slicedImageConformity->expects($this->never())
            ->method('getOptimalSize');

        $resizeFactory = new ResizeFactory(null, $slicedImageConformity);
        $resizer = $resizeFactory->getSlicedImageResize(
            $this->getImageMock(),
            [$portraitResolution]
        );

        $this->assertEquals(
            SlicedImageResize::class,
            get_class($resizer)
        );
        $this->assertEquals(
            $portraitResolution,
            $resizer->getResolution()
        );
    }

    public function testGetSlicedImageResizeMultipleResolutions()
    {
        $image = $this->getImageMock();
        $portraitResolution = new PortraitResolution();
        $landscapeResolution = new LandscapeResolution();
        $resolutions = [$portraitResolution, $landscapeResolution];

        $slicedImageConformity = $this->createMock(SlicedImageConformity::class);
        $slicedImageConformity->expects($this->once())
            ->method('getOptimalSize')
            ->with(
                $resolutions,
                $image->getWidth(),
                $image->getHeight()
            )
            ->willReturn($landscapeResolution);

        $resizeFactory = new ResizeFactory(null, $slicedImageConformity);
        $resizer = $resizeFactory->getSlicedImageResize(
            $this->getImageMock(),
            $resolutions
        );

        $this->assertEquals(
            SlicedImageResize::class,
            get_class($resizer)
        );
        $this->assertEquals(
            $landscapeResolution,
            $resizer->getResolution()
        );
    }

    public function testGetGeneralOptimal()
    {
        $this->expectException(FileNotFoundException::class);

        $resizeFactory = new ResizeFactory();
        $resizeFactory->getGeneralOptimal('', []);
    }

    public function testGetGeneralOptimalImageSolidOnEqual()
    {
        $image = $this->getImageMock();
        $portraitResolution = new PortraitResolution();
        $landscapeResolution = new LandscapeResolution();
        $resolutions = [$portraitResolution, $landscapeResolution];

        $solidImageConformity = $this->createMock(SolidImageConformity::class);
        $solidImageConformity->expects($this->once())
            ->method('getOptimalSize')
            ->with(
                $resolutions,
                $image->getWidth(),
                $image->getHeight()
            )
            ->willReturn($landscapeResolution);
        $solidImageConformity->expects($this->once())
            ->method('getConformity')
            ->willReturn(80);

        $slicedImageConformity = $this->createMock(SlicedImageConformity::class);
        $slicedImageConformity->expects($this->once())
            ->method('getOptimalSize')
            ->with(
                $resolutions,
                $image->getWidth(),
                $image->getHeight()
            )
            ->willReturn($portraitResolution);
        $slicedImageConformity->expects($this->once())
            ->method('getConformity')
            ->willReturn(80);

        $resizeFactory = new ResizeFactory($solidImageConformity, $slicedImageConformity);
        $resizer = $resizeFactory->getGeneralOptimalImage(
            $this->getImageMock(),
            $resolutions
        );

        $this->assertEquals(
            SolidImageResize::class,
            get_class($resizer)
        );
        $this->assertEquals(
            $landscapeResolution,
            $resizer->getResolution()
        );
    }

    public function testGetGeneralOptimalImageSliced()
    {
        $image = $this->getImageMock();
        $portraitResolution = new PortraitResolution();
        $landscapeResolution = new LandscapeResolution();
        $resolutions = [$portraitResolution, $landscapeResolution];

        $solidImageConformity = $this->createMock(SolidImageConformity::class);
        $solidImageConformity->expects($this->once())
            ->method('getOptimalSize')
            ->with(
                $resolutions,
                $image->getWidth(),
                $image->getHeight()
            )
            ->willReturn($landscapeResolution);
        $solidImageConformity->expects($this->once())
            ->method('getConformity')
            ->willReturn(80);

        $slicedImageConformity = $this->createMock(SlicedImageConformity::class);
        $slicedImageConformity->expects($this->once())
            ->method('getOptimalSize')
            ->with(
                $resolutions,
                $image->getWidth(),
                $image->getHeight()
            )
            ->willReturn($portraitResolution);
        $slicedImageConformity->expects($this->once())
            ->method('getConformity')
            ->willReturn(90);

        $resizeFactory = new ResizeFactory($solidImageConformity, $slicedImageConformity);
        $resizer = $resizeFactory->getGeneralOptimalImage(
            $this->getImageMock(),
            $resolutions
        );

        $this->assertEquals(
            SlicedImageResize::class,
            get_class($resizer)
        );
        $this->assertEquals(
            $portraitResolution,
            $resizer->getResolution()
        );
    }

    private function getImageMock()
    {
        $image = $this->createMock(Image::class);
        $image->method('getWidth')
            ->willReturn(100);
        $image->method('getHeight')
            ->willReturn(200);

        return $image;
    }
}
