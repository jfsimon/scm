<?php

namespace Scm\Command\Git;

use Scm\Command\InfosCommand;
use Scm\Command\InfosCommandInterface;

class BranchesInfos extends InfosCommand implements InfosCommandInterface
{
    protected $repository;

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository($repository)
    {
        $this->repository = $this->getRealRepository($repository);
    }

    public function execute($processCallback=null)
    {
        if($this->repository) {
            $command = 'git fetch';

            if($this->options['verbose']) {
                $command .= ' -v';
            }

            $command .= ' '.$this->repository;
            $this->runProcess($command, $processCallback);
        }

        $command = 'git branch';

        if($this->options['verbose']) {
            $command .= ' -v';
        }

        $this->runProcess($command, $processCallback);
    }

    protected function parseResult(array $result)
    {
        $branches = array();

        foreach($result as $row) {
            $bits = explode(' ', trim($row, " \t*"));

            if(strlen($bits[0])) {
                $branches[] = $bits[0];
            }
        }

        return $branches;
    }
}