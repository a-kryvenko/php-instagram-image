<?php

namespace Antey\InstagramImage\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\Exception\FileNotFoundException
 */
class FileNotFoundExceptionTest extends TestCase
{
    public function testThrow(): void
    {
        $path = 'sone-path';

        $this->expectExceptionMessage(sprintf('File "%s" not found.', $path));

        throw new FileNotFoundException($path);
    }
}
