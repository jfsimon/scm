<?php

namespace Scm\Command\Git;

use Scm\Command\Command;
use Scm\Command\CommandInterface;

class Unsuscribe extends Command implements CommandInterface
{
    public function execute($processCallback=null)
    {
        $this->removeFiles($this->directory, array('.git', '.git*'));
    }
}