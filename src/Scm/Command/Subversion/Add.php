<?php

namespace Scm\Command\Subversion;

use Scm\Command\CommandInterface;
use Symfony\Component\Finder\Finder;

class Add extends Command implements CommandInterface
{
    protected $path;
    protected $ignore;

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

        $finder = new Finder();
        $files = $finder->files()->in($this->path);

        foreach($files as $file) {
            $this->executeFile($file, $processCallback);
        }
    }

    protected function executeFile($file, $processCallback=null)
    {
        $command = 'svn add \''.$file.'\'';
        $this->runProcess($command, $processCallback);
    }
}