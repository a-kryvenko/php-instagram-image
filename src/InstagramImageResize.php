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
     * Resize image into profile cover, <b>365</b>x<b>365</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * filename of result file.
     * If empty, will be replaced original file
     * </p>
     * @return string path to resized file
     * @throws Exception
     */
    public function getProfile(string $filename, string $destination = ''): string
    {
        return $this->getSingle($filename, [new ProfileResolution()], $destination);
    }

    /**
     * Resize image and slice into several stories, <b>1080</b>x<b>1920</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * path to folder for stories slices.
     * If empty, will be stored near to original file, in directory
     * named "filename.jpeg"
     * </p>
     * @return array array of paths to stories images
     * @throws Exception
     */
    public function getStories(string $filename, string $destination = ''): array
    {
        return $this->getSliced($filename, [new FullscreenResolution()], $destination);
    }

    /**
     * Resize image and slice into several reels, <b>1080</b>x<b>1920</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * path to folder for reels slices.
     * If empty, will be stored near to original file, in directory
     * named "filename.jpeg"
     * </p>
     * @return array array of paths to reels images
     * @throws Exception
     */
    public function getReels(string $filename, string $destination = ''): array
    {
        return $this->getSliced($filename, [new FullscreenResolution()], $destination);
    }

    /**
     * Resize image into IGTV cover, <b>420</b>x<b>654</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * filename of result file.
     * If empty, will be replaced original file
     * </p>
     * @return string path to resized file
     * @throws Exception
     */
    public function getIgtvCover(string $filename, string $destination = ''): string
    {
        return $this->getSingle($filename, [new IGTVCoverResolution()], $destination);
    }

    /**
     * Resize image into Square Post, <b>1080</b>x<b>1080</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * filename of result file.
     * If empty, will be replaced original file
     * </p>
     * @return string path to resized file
     * @throws Exception
     */
    public function getSinglePostSquare(string $filename, string $destination = ''): string
    {
        return $this->getSingle($filename, [new SquareResolution()], $destination);
    }

    /**
     * Resize image into Landscape Post, <b>1080</b>x<b>565</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * filename of result file.
     * If empty, will be replaced original file
     * </p>
     * @return string path to resized file
     * @throws Exception
     */
    public function getSinglePostLandscape(string $filename, string $destination = ''): string
    {
        return $this->getSingle($filename, [new LandscapeResolution()], $destination);
    }

    /**
     * Resize image into Portrait Post, <b>1080</b>x<b>1350</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * filename of result file.
     * If empty, will be replaced original file
     * </p>
     * @return string path to resized file
     * @throws Exception
     */
    public function getSinglePostPortrait(string $filename, string $destination = ''): string
    {
        return $this->getSingle($filename, [new PortraitResolution()], $destination);
    }

    /**
     * Resize image into optimal resolution (Square, Landscape, Portrait)
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * filename of result file.
     * If empty, will be replaced original file
     * </p>
     * @return string path to resized file
     * @throws Exception
     */
    public function getSinglePostOptimal(string $filename, string $destination = ''): string
    {
        return $this->getSingle(
            $filename,
            [
                new SquareResolution(),
                new LandscapeResolution(),
                new PortraitResolution(),
            ],
            $destination
        );
    }

    /**
     * Resize image and slice into several Square Posts, <b>1080</b>x<b>1080</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * path to folder for reels slices.
     * If empty, will be stored near to original file, in directory
     * named "filename.jpeg"
     * </p>
     * @return array array of paths to gallery images
     * @throws Exception
     */
    public function getGallerySquare(string $filename, string $destination = ''): array
    {
        return $this->getSliced($filename, [new SquareResolution()], $destination);
    }

    /**
     * Resize image and slice into several Landscape Posts, <b>1080</b>x<b>565</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * path to folder for reels slices.
     * If empty, will be stored near to original file, in directory
     * named "filename.jpeg"
     * </p>
     * @return array array of paths to gallery images
     * @throws Exception
     */
    public function getGalleryLandscape(string $filename, string $destination = ''): array
    {
        return $this->getSliced($filename, [new LandscapeResolution()], $destination);
    }

    /**
     * Resize image and slice into several Portrait Posts, <b>1080</b>x<b>1350</b> px
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * path to folder for reels slices.
     * If empty, will be stored near to original file, in directory
     * named "filename.jpeg"
     * </p>
     * @return array array of paths to gallery images
     * @throws Exception
     */
    public function getGalleryPortrait(string $filename, string $destination = ''): array
    {
        return $this->getSliced($filename, [new PortraitResolution()], $destination);
    }

    /**
     * Resize image and slice into several Posts in most reliable resolution
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * path to folder for reels slices.
     * If empty, will be stored near to original file, in directory
     * named "filename.jpeg"
     * </p>
     * @return array array of paths to gallery images
     * @throws Exception
     */
    public function getGalleryOptimal(string $filename, string $destination = ''): array
    {
        return $this->getSliced(
            $filename,
            [
                new SquareResolution(),
                new LandscapeResolution(),
                new PortraitResolution(),
            ],
            $destination
        );
    }

    /**
     * Resize image and based on image resolution, resize into single post,
     * or slice to gallery in most reliable resolution.
     *
     * @param string $filename path to file you wish to resize
     * @param string $destination <p>
     * path to folder for reels slices.
     * If empty, will be stored near to original file, in directory
     * named "filename.jpeg"
     * </p>
     * @return array array of paths to resized images
     * @throws Exception
     */
    public function getOptimalPost(string $filename, string $destination = ''): array
    {
        $resize = $this->resizeFactory->getGeneralOptimal(
            $filename,
            [
                new SquareResolution(),
                new LandscapeResolution(),
                new PortraitResolution(),
            ]
        );

        return $resize->resize($destination ?: $filename);
    }

    /**
     * @param string $filename
     * @param ImageResolutionInterface[] $imageResolutions
     * @param string $destination
     * @return string
     * @throws Exception
     */
    private function getSingle(string $filename, array $imageResolutions, string $destination): string
    {
        $resize = $this->resizeFactory->getSingle($filename, $imageResolutions);
        return $resize->resize($destination ?: $filename)[0];
    }

    /**
     * @param string $filename
     * @param ImageResolutionInterface[] $imageResolutions
     * @param string $destination
     * @return array
     * @throws Exception
     */
    private function getSliced(string $filename, array $imageResolutions, string $destination): array
    {
        $resize = $this->resizeFactory->getSliced($filename, $imageResolutions);
        return $resize->resize($destination ?: $filename);
    }
}
