<?php

namespace Scm\Command;

use Scm\Command\Command;

abstract class InfosCommand extends Command
{
    public function getResult()
    {
        if(! $this->process->isSuccessful()) {
            return null;
        }

        return $this->parseResult(explode("\n", $this->process->getOutput()));
    }

    abstract protected function parseResult(array $result);
}