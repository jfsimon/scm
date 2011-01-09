<?php

namespace Scm\Executor;

use Scm\Executor\Log;
use Scm\Executor\Env;
use Symfony\Component\Finder\Finder;

abstract class Executor
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

    protected function runtimeException($type, $message)
    {
        $this->log->add($type, $message);

        if((isset($this->options) && is_array($this->options) && isset($this->options['fail-silently'])) ? $this->options['fail-silently'] : false) {
            return $this;
        } else {
            throw new \RuntimeException('['.$type.']: '.$message);
        }
    }
}