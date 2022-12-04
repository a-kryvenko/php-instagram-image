<?php

namespace Antey\InstagramImage;

use Antey\InstagramImage\Resize\ResizeFactory;
use Antey\InstagramImage\Resolution\FullscreenResolution;
use Antey\InstagramImage\Resolution\IGTVCoverResolution;
use Antey\InstagramImage\Resolution\ImageResolutionInterface;
use Antey\InstagramImage\Resolution\LandscapeResolution;
use Antey\InstagramImage\Resolution\PortraitResolution;
use Antey\InstagramImage\Resolution\ProfileResolution;
use Antey\InstagramImage\Resolution\SquareResolution;
use Exception;

class InstagramImageResize
{
    private ResizeFactory $resizeFactory;

    public function __construct(ResizeFactory $resizeFactory = null)
    {
        if ($resizeFactory) {
            $this->resizeFactory = $resizeFactory;
        } else {
            $this->resizeFactory = new ResizeFactory();
        }
    }

    /**
     * @param string $path path to profile cover, 365x365 px
     * @param string $destination <p>
     * destination of result file.
     * If empty, then will be replaced original file
     * </p>
     * @return string
     * @throws Exception
     */
    public function getProfile(string $path, string $destination = ''): string
    {
        return $this->getSingle($path, [new ProfileResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @return array paths to stories images, 1080x1920 px
     * @throws Exception
     */
    public function getStories(string $path, string $destination = ''): array
    {
        return $this->getSliced($path, [new FullscreenResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @return array paths to reels images, 1080x1920 px
     * @throws Exception
     */
    public function getReels(string $path, string $destination = ''): array
    {
        return $this->getSliced($path, [new FullscreenResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result file.
     * If empty, then will be replaced original file
     * </p>
     * @return string path to IGTV cover, 420x654 px
     * @throws Exception
     */
    public function getIgtvCover(string $path, string $destination = ''): string
    {
        return $this->getSingle($path, [new IGTVCoverResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result file.
     * If empty, then will be replaced original file
     * </p>
     * @return string path to post image, 1080x1080 px
     * @throws Exception
     */
    public function getSinglePostSquare(string $path, string $destination = ''): string
    {
        return $this->getSingle($path, [new SquareResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result file.
     * If empty, then will be replaced original file
     * </p>
     * @return string path to post image, 1080x565 px
     * @throws Exception
     */
    public function getSinglePostLandscape(string $path, string $destination = ''): string
    {
        return $this->getSingle($path, [new LandscapeResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result file.
     * If empty, then will be replaced original file
     * </p>
     * @return string path to post image, 1080x1350 px
     * @throws Exception
     */
    public function getSinglePostPortrait(string $path, string $destination = ''): string
    {
        return $this->getSingle($path, [new PortraitResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result file.
     * If empty, then will be replaced original file
     * </p>
     * @return string path to post image, detected optimal resolution (square/landscape/portrait)
     * @throws Exception
     */
    public function getSinglePostOptimal(string $path, string $destination = ''): string
    {
        return $this->getSingle(
            $path,
            [
                new SquareResolution(),
                new LandscapeResolution(),
                new PortraitResolution(),
            ],
            $destination
        );
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result files.
     * If empty, then will be stored near to original file
     * </p>
     * @return array paths to post images, 1080x1080 px
     * @throws Exception
     */
    public function getGallerySquare(string $path, string $destination = ''): array
    {
        return $this->getSliced($path, [new SquareResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result files.
     * If empty, then will be stored near to original file
     * </p>
     * @return array paths to post images, 1080x565 px
     * @throws Exception
     */
    public function getGalleryLandscape(string $path, string $destination = ''): array
    {
        return $this->getSliced($path, [new LandscapeResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result files.
     * If empty, then will be stored near to original file
     * </p>
     * @return array paths to post images, 1080x1350 px
     * @throws Exception
     */
    public function getGalleryPortrait(string $path, string $destination = ''): array
    {
        return $this->getSliced($path, [new PortraitResolution()], $destination);
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result files.
     * If empty, then will be stored near to original file
     * </p>
     * @return array paths to post images, detected optimal resolution (square/landscape/portrait)
     * @throws Exception
     */
    public function getGalleryOptimal(string $path, string $destination = ''): array
    {
        return $this->getSliced(
            $path,
            [
                new SquareResolution(),
                new LandscapeResolution(),
                new PortraitResolution(),
            ],
            $destination
        );
    }

    /**
     * @param string $path of file wile you wish to resize
     * @param string $destination <p>
     * destination of result files.
     * If empty, then will be stored near to original file
     * </p>
     * @return array <p>
     * paths to post images, detected optimal resolution (square/landscape/portrait).
     * Can be a gallery, or single image.
     * </p>
     * @throws Exception
     */
    public function getOptimalPost(string $path, string $destination = ''): array
    {
        $resize = $this->resizeFactory->getGeneralOptimal(
            $path,
            [
                new SquareResolution(),
                new LandscapeResolution(),
                new PortraitResolution(),
            ]
        );

        return $resize->resize($destination ?: $path);
    }

    /**
     * @param string $path
     * @param ImageResolutionInterface[] $imageResolutions
     * @param string $destination
     * @return string
     * @throws Exception
     */
    private function getSingle(string $path, array $imageResolutions, string $destination): string
    {
        $resize = $this->resizeFactory->getSingle($path, $imageResolutions);
        return $resize->resize($destination ?: $path)[0];
    }

    /**
     * @param string $path
     * @param ImageResolutionInterface[] $imageResolutions
     * @param string $destination
     * @return array
     * @throws Exception
     */
    private function getSliced(string $path, array $imageResolutions, string $destination): array
    {
        $resize = $this->resizeFactory->getSliced($path, $imageResolutions);
        return $resize->resize($destination ?: $path);
    }
}
