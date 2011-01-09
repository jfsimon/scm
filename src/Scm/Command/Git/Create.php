<?php

namespace Scm\Command\Git;

use Scm\Command\Command;
use Scm\Command\CommandInterface;

class Create extends Command implements CommandInterface
{
    protected $template;

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function execute($processCallback=null)
    {
        $this->makeDirectory();

        $command = 'git init';

        if($this->template && file_exists($this->template && is_dir($this->template))) {
            $command .= ' --template=\''.$this->template.'\'';
        }

        $this->runProcess($command, $processCallback);
    }
}