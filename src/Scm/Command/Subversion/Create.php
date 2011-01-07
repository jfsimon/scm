<?php

namespace Scm\Command\Git;

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

        $command = '';

        // TODO: implement this

        $this->runProcess($command, $processCallback);
    }
}