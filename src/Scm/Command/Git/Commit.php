<?php

namespace Scm\Command\Git;

use Scm\Command\CommandInterface;

class Commit extends Command implements CommandInterface
{
    protected $message;
    protected $branch;

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getBranch()
    {
        return $this->repository;
    }

    public function setBranch($branch)
    {
        $this->branch = $branch;
    }

    public function execute($processCallback=null)
    {
        $this->executeCommit($processCallback);
        $this->executePull($processCallback);
    }

    protected function executeCommit($processCallback=null)
    {
        $command = 'git commit -v -m "'.str_replace('"', "'", $this->message).'"';
        $this->runProcess($command, $processCallback);
    }

    protected function executePull($processCallback=null)
    {
        $command = 'git push -v -f ';

        if($this->branch) {
            $command .= ' '.$this->repository.' '.$this->branch;
        }

        $this->runProcess($command, $processCallback);
    }
}