<?php

namespace Antey\InstagramImage\Exception;

use Exception;

class WrongFileExtensionException extends Exception
{
    public function __construct(string $path)
    {
        parent::__construct('File "' . $path . '" has unsupported extension.');
    }
}
