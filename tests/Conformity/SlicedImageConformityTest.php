<?php

namespace Antey\InstagramImage\Conformity;

use Antey\InstagramImage\Resolution\ImageResolutionInterface;
use Antey\InstagramImage\Resolution\LandscapeResolution;
use Antey\InstagramImage\Resolution\PortraitResolution;
use Antey\InstagramImage\Resolution\SquareResolution;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\Conformity\SlicedImageConformity
 * @covers \Antey\InstagramImage\Conformity\AbstractImageConformity
 * @uses \Antey\InstagramImage\Conformity\AbstractImageConformity
 * @uses \Antey\InstagramImage\Resolution\SquareResolution
 * @uses \Antey\InstagramImage\Resolution\LandscapeResolution
 * @uses \Antey\InstagramImage\Resolution\PortraitResolution
 */
class SlicedImageConformityTest extends TestCase
{
    public function testEmptyResolutions(): void
    {
        $this->expectExceptionMessage('Unsupported image resolution');
        $imageConformity = new SolidImageConformity();
        $imageConformity->getOptimalSize([], 10, 10);
    }
    /**
     * @param int $width
     * @param int $height
     * @param array $imageResolutions
     * @param ImageResolutionInterface $expectedResolution
     * @return void
     * @throws Exception
     * @dataProvider optimalResolutionDataProvider
     */
    public function testGetOptimalSize(
        int $width,
        int $height,
        array $imageResolutions,
        ImageResolutionInterface $expectedResolution
    ): void
    {
        $conformity = new SlicedImageConformity();
        $this->assertEquals(
            $expectedResolution,
            $conformity->getOptimalSize($imageResolutions, $width, $height)
        );
    }

    /**
     * @param int $wishWidth
     * @param int $wishHeight
     * @param int $width
     * @param int $height
     * @param int $expectedConformity
     * @return void
     * @dataProvider imageConformityDataProvider
     */
    public function testGetConformity(
        int $wishWidth,
        int $wishHeight,
        int $width,
        int $height,
        int $expectedConformity
    ): void
    {
        $conformity = new SlicedImageConformity();
        $this->assertEquals(
            $expectedConformity,
            $conformity->getConformity($wishWidth, $wishHeight, $width, $height)
        );
    }

    public function optimalResolutionDataProvider(): array
    {
        $square = new SquareResolution();
        $landscape = new LandscapeResolution();
        $portrait = new PortraitResolution();
        $resolutions = [$square, $landscape, $portrait];

        return [
            '1080x1080' => [1080, 1080, $resolutions, $square],
            '1080x1120' => [1080, 1120, $resolutions, $portrait],
            '1080x1350' => [1080, 1350, $resolutions, $portrait],
            '1080x565' => [1080, 565, $resolutions, $landscape],
            '1080x900' => [1080, 900, $resolutions, $square]
        ];
    }

    public function imageConformityDataProvider(): array
    {
        return [
            '1079x1080' => [1080, 1080, 1079, 1080, 0],
            '1080x1079' => [1080, 1080, 1080, 1079, 99],
            '1080x1080' => [1080, 1080, 1080, 1080, 100],
            '1080x565'  => [1080, 1080, 1080, 565, 8],
            '1080x1350' => [1080, 1080, 1080, 1350, 0],
        ];
    }
}
