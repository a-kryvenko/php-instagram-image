<?php

namespace Antey\InstagramImage\Image;

use Antey\InstagramImage\Exception\FileNotFoundException;
use Antey\InstagramImage\Exception\WrongFileExtensionException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\Image\Image
 * @uses \Antey\InstagramImage\Exception\FileNotFoundException
 * @uses \Antey\InstagramImage\Exception\WrongFileExtensionException
 */
class ImageTest extends TestCase
{
    public function testFileNotFound(): void
    {
        $this->expectException(FileNotFoundException::class);
        $image = new Image('');
    }

    public function testWrongExtension(): void
    {
        $this->expectException(WrongFileExtensionException::class);

        $path = __DIR__ . '/testfile.txt';
        file_put_contents($path, '');
        try {
            $image = new Image($path);
        } catch (WrongFileExtensionException $e) {
            unlink($path);
            throw $e;
        }
        unlink($path);
    }

    public function testCorrectImage(): void
    {
        $path = __DIR__ . '/testfile.jpeg';
        $width = 20;
        $height = 30;

        $source = imagecreate($width, $height);
        imagejpeg($source, $path, 100);

        $image = new Image($path);

        $this->assertEquals($width, $image->getWidth());
        $this->assertEquals($height, $image->getHeight());
        $this->assertEquals($path, $image->getPath());

        unlink($path);
    }
}
