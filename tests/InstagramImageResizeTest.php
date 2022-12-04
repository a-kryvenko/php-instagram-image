<?php

namespace Antey\InstagramImage;

use Antey\InstagramImage\Exception\FileNotFoundException;
use Antey\InstagramImage\Resize\AbstractResize;
use Antey\InstagramImage\Resize\ResizeFactory;
use Antey\InstagramImage\Resolution\FullscreenResolution;
use Antey\InstagramImage\Resolution\IGTVCoverResolution;
use Antey\InstagramImage\Resolution\LandscapeResolution;
use Antey\InstagramImage\Resolution\PortraitResolution;
use Antey\InstagramImage\Resolution\ProfileResolution;
use Antey\InstagramImage\Resolution\SquareResolution;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\InstagramImageResize
 * @uses \Antey\InstagramImage\Resize\ResizeFactory
 * @uses \Antey\InstagramImage\Image\Image
 * @uses \Antey\InstagramImage\Exception\FileNotFoundException
 */
class InstagramImageResizeTest extends TestCase
{
    public function testConstructorWithoutParameters(): void
    {
        $this->expectException(FileNotFoundException::class);

        $instagramResize = new InstagramImageResize();
        $path = $instagramResize->getProfile('test.jpeg');
    }

    public function testConstructorWithParameters(): void
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory->method('getSingle')
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            $expectedPath,
            $instagramResize->getProfile($expectedPath)
        );
    }

    public function testGetProfile()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSingle')
            ->with($expectedPath, [new ProfileResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            $expectedPath,
            $instagramResize->getProfile($expectedPath)
        );
    }

    public function testGetStories()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSliced')
            ->with($expectedPath, [new FullscreenResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            [$expectedPath],
            $instagramResize->getStories($expectedPath)
        );
    }

    public function testGetReels()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSliced')
            ->with($expectedPath, [new FullscreenResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            [$expectedPath],
            $instagramResize->getReels($expectedPath)
        );
    }

    public function testGetIgtvCover()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSingle')
            ->with($expectedPath, [new IGTVCoverResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            $expectedPath,
            $instagramResize->getIgtvCover($expectedPath)
        );
    }

    public function testGetSinglePostSquare()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSingle')
            ->with($expectedPath, [new SquareResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            $expectedPath,
            $instagramResize->getSinglePostSquare($expectedPath)
        );
    }

    public function testGetSinglePostLandscape()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSingle')
            ->with($expectedPath, [new LandscapeResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            $expectedPath,
            $instagramResize->getSinglePostLandscape($expectedPath)
        );
    }

    public function testGetSinglePostPortrait()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSingle')
            ->with($expectedPath, [new PortraitResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            $expectedPath,
            $instagramResize->getSinglePostPortrait($expectedPath)
        );
    }

    public function testGetSinglePostOptimal()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSingle')
            ->with($expectedPath, [
                new SquareResolution(),
                new LandscapeResolution(),
                new PortraitResolution()
            ])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            $expectedPath,
            $instagramResize->getSinglePostOptimal($expectedPath)
        );
    }

    public function testGetGallerySquare()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSliced')
            ->with($expectedPath, [new SquareResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            [$expectedPath],
            $instagramResize->getGallerySquare($expectedPath)
        );
    }

    public function testGetGalleryLandscape()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSliced')
            ->with($expectedPath, [new LandscapeResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            [$expectedPath],
            $instagramResize->getGalleryLandscape($expectedPath)
        );
    }

    public function testGetGalleryPortrait()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSliced')
            ->with($expectedPath, [new PortraitResolution()])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            [$expectedPath],
            $instagramResize->getGalleryPortrait($expectedPath)
        );
    }

    public function testGetGalleryOptimal()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getSliced')
            ->with($expectedPath, [
                new SquareResolution(),
                new LandscapeResolution(),
                new PortraitResolution()
            ])
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            [$expectedPath],
            $instagramResize->getGalleryOptimal($expectedPath)
        );
    }

    public function testGetOptimalPost()
    {
        $expectedPath = '/test.jpeg';

        $resize = $this->createMock(AbstractResize::class);
        $resize->method('resize')
            ->willReturn([$expectedPath]);

        $resizeFactory = $this->createMock(ResizeFactory::class);
        $resizeFactory
            ->expects($this->once())
            ->method('getGeneralOptimal')
            ->with(
                $expectedPath,
                [
                    new SquareResolution(),
                    new LandscapeResolution(),
                    new PortraitResolution()
                ]
            )
            ->willReturn($resize);

        $instagramResize = new InstagramImageResize($resizeFactory);

        $this->assertEquals(
            [$expectedPath],
            $instagramResize->getOptimalPost($expectedPath)
        );
    }
}
