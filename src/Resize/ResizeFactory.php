<?php

namespace Antey\InstagramImage\Resize;

use Antey\InstagramImage\Conformity\AbstractImageConformity;
use Antey\InstagramImage\Conformity\SlicedImageConformity;
use Antey\InstagramImage\Conformity\SolidImageConformity;
use Antey\InstagramImage\Exception\FileNotFoundException;
use Antey\InstagramImage\Exception\InstagramImageException;
use Antey\InstagramImage\Exception\WrongFileExtensionException;
use Antey\InstagramImage\Image\Image;
use Antey\InstagramImage\Image\ImageInterface;
use Antey\InstagramImage\Resolution\ImageResolutionInterface;
use Exception;

class ResizeFactory
{
    protected AbstractImageConformity $solidImageConformity;
    protected AbstractImageConformity $slicedImageConformity;

    public function __construct(
        AbstractImageConformity $solidImageConformity = null,
        AbstractImageConformity $slicedImageConformity = null
    )
    {
        if ($solidImageConformity) {
            $this->solidImageConformity = $solidImageConformity;
        } else {
            $this->solidImageConformity = new SolidImageConformity();
        }

        if ($slicedImageConformity) {
            $this->slicedImageConformity = $slicedImageConformity;
        } else {
            $this->slicedImageConformity = new SlicedImageConformity();
        }
    }

    /**
     * @param string $path
     * @param ImageResolutionInterface[] $imageResolutions
     * @return AbstractResize
     * @throws FileNotFoundException
     * @throws InstagramImageException
     * @throws WrongFileExtensionException
     */
    public function getSingle(
        string $path,
        array $imageResolutions
    ): AbstractResize
    {
        return $this->getSingleImageResize(
            new Image($path),
            $imageResolutions
        );
    }

    /**
     * @param Image $image
     * @param ImageResolutionInterface[] $imageResolutions
     * @return AbstractResize
     * @throws InstagramImageException
     */
    public function getSingleImageResize(
        Image $image,
        array $imageResolutions
    ): AbstractResize
    {
        return new SolidImageResize(
            $image,
            $this->getOptimalResolution(
                $this->solidImageConformity,
                $image,
                $imageResolutions
            )
        );
    }

    /**
     * @param string $path
     * @param ImageResolutionInterface[] $imageResolutions
     * @return AbstractResize
     * @throws InstagramImageException
     * @throws FileNotFoundException
     * @throws WrongFileExtensionException
     */
    public function getSliced(
        string $path,
        array $imageResolutions
    ): AbstractResize
    {
        return $this->getSlicedImageResize(
            new Image($path),
            $imageResolutions
        );
    }

    /**
     * @param Image $image
     * @param ImageResolutionInterface[] $imageResolutions
     * @return AbstractResize
     * @throws InstagramImageException
     */
    public function getSlicedImageResize(
        Image $image,
        array $imageResolutions
    ): AbstractResize
    {
        return new SlicedImageResize(
            $image,
            $this->getOptimalResolution(
                $this->slicedImageConformity,
                $image,
                $imageResolutions
            )
        );
    }

    /**
     * @param string $path
     * @param ImageResolutionInterface[] $imageResolutions
     * @return AbstractResize
     * @throws FileNotFoundException
     * @throws InstagramImageException
     * @throws WrongFileExtensionException
     */
    public function getGeneralOptimal(
        string $path,
        array $imageResolutions
    ): AbstractResize
    {
        return $this->getGeneralOptimalImage(
            new Image($path),
            $imageResolutions
        );
    }

    /**
     * @param ImageInterface $image
     * @param ImageResolutionInterface[] $imageResolutions
     * @return AbstractResize
     * @throws InstagramImageException
     */
    public function getGeneralOptimalImage(
        ImageInterface  $image,
        array $imageResolutions
    ): AbstractResize
    {
        $solidResolution = $this->getOptimalResolution(
            $this->solidImageConformity,
            $image,
            $imageResolutions
        );
        $solidConformity = $this->solidImageConformity->getConformity(
            $solidResolution->getWidth(),
            $solidResolution->getHeight(),
            $image->getWidth(),
            $image->getHeight()
        );

        $slicedResolution = $this->getOptimalResolution(
            $this->slicedImageConformity,
            $image,
            $imageResolutions
        );
        $slicedConformity = $this->slicedImageConformity->getConformity(
            $slicedResolution->getWidth(),
            $slicedResolution->getHeight(),
            $image->getWidth(),
            $image->getHeight()
        );

        if ($slicedConformity > $solidConformity) {
            $resizer = new SlicedImageResize($image, $slicedResolution);
        } else {
            $resizer = new SolidImageResize($image, $solidResolution);
        }

        return $resizer;
    }

    /**
     * @param AbstractImageConformity $imageConformity
     * @param ImageInterface $image
     * @param ImageResolutionInterface[] $imageResolutions
     * @return ImageResolutionInterface optimal resolution for given image
     * @throws InstagramImageException
     * @throws Exception
     */
    protected function getOptimalResolution(
        AbstractImageConformity $imageConformity,
        ImageInterface $image,
        array $imageResolutions
    ): ImageResolutionInterface
    {
        if (count($imageResolutions) === 0) {
            throw new InstagramImageException('Required at least one resolution. Zero given.');
        }

        if (count($imageResolutions) === 1) {
            $optimalResolution =  $imageResolutions[0];
        } else {
            $optimalResolution = $imageConformity->getOptimalSize(
                $imageResolutions,
                $image->getWidth(),
                $image->getHeight()
            );
        }

        return $optimalResolution;
    }
}
