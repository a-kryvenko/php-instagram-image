<?php

namespace Antey\InstagramImage\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Antey\InstagramImage\Exception\WrongFileExtensionException
 */
class WrongFileExtensionExceptionTest extends TestCase
{
    public function testThrow(): void
    {
        $path = 'sone-path';

        $this->expectExceptionMessage(sprintf('File "%s" has unsupported extension.', $path));

        throw new WrongFileExtensionException($path);
    }
}
