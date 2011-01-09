<?php

namespace Scm\Command\Git;

use Scm\Command\Command;
use Scm\Command\CommandInterface;

class Sub extends Command implements CommandInterface
{
    protected $path;

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path=null)
    {
        $this->path = $this->getRealPath($path ? $path : '.');
    }

    public function execute($processCallback=null)
    {
        if(! $this->path) {
            return;
        }

        $command = 'git rm -rf --ignore-unmatch '.$this->path;

        $this->runProcess($command, $processCallback);
    }
}