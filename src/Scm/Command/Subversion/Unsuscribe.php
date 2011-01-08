<?php

namespace Scm\Command\Subversion;

use Scm\Command\CommandInterface;

class Unsuscribe extends Command implements CommandInterface
{
    public function execute($processCallback=null)
    {
        $this->removeFiles($this->directory, array('.svn'));
    }
}