<?php

namespace Scm\Exception;

class PathNotFoundException extends \RuntimeException
{
    public function __construct($path, $code=0, $previous=null)
    {
        $message = 'Path "'.$path.'" not found';

        parent::__construct($message, $code, $previous);
    }
}