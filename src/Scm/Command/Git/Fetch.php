<?php

namespace Scm\Command\Git;

use Scm\Command\CommandInterface;

class Fetch extends Command implements CommandInterface
{
    protected $repository;
    protected $branch;

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository($repository)
    {
        $this->repository = $repository;
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
        if($this->isRepository()) {
            return $this->executeUpdate($processCallback);
        }

        return $this->executeClone($processCallback);
    }

    protected function executeUpdate($processCallback=null)
    {
        // TODO: find the better way to do this !!
    }

    protected function executeClone($processCallback=null)
    {
        $command = 'git clone --recursive';

        $branch = static::$env->getBranch($this->branch);

        if($branch) {
            $command .= ' --branch '.$branch;
        }

        $command .= ' '.static::$env->getAlias(static::$env->getRepository($this->repository)).' '.$this->directory;

        return $this->runProcess($command);
    }
}