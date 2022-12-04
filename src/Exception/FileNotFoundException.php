<?php

namespace Antey\InstagramImage\Exception;

use Exception;

class FileNotFoundException extends Exception
{
    public function __construct(string $path)
    {
        parent::__construct('File "' . $path . '" not found.');
    }
}
