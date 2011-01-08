<?php

namespace Scm;

use Scm\Log\Log;
use Scm\Env\Env;

class Executor
{
    public $log;
    static public $env;

    public function __construct()
    {
        $this->log = new Log();

        if(! is_object(static::$env)) {
            static::$env = new Env();
        }
    }
}