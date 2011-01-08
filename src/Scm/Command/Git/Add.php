<?php

namespace Scm\Command\Git;

use Scm\Command\CommandInterface;

class Add extends Command implements CommandInterface
{
    protected $path;

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function execute($processCallback=null)
    {
        $this->makeDirectory();

        $command = 'git add --ignore-errors --ignore-missing';

        if($this->options['verbose']) {
            $command .= ' -v';
        }

        $command .= ' \''.static::$env->getAlias($this->path).'\'';

        $this->runProcess($command, $processCallback);
    }
}