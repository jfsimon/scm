<?php

namespace Scm\Command\Git;

use Scm\Command\Command;
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
        $this->repository = $this->getRealRepository($repository);
    }

    public function getBranch()
    {
        return $this->repository;
    }

    public function setBranch($branch)
    {
        $this->branch = $this->getRealBranch($branch);
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

        if($this->branch) {
            $command .= ' --branch '.$this->branch;
        }

        $command .= ' '.$this->repository.' '.$this->directory;

        return $this->runProcess($command);
    }

    protected function isRepository($directory=null)
    {
        $directory = is_null($directory) ? $this->directory : $directory;
        $test = $directory.DIRECTORY_SEPARATOR.'.git';

        return file_exists($test) && is_dir($test);
    }
}