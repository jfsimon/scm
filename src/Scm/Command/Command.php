<?php

namespace Scm\Command;

use Scm\Filesystem;

use Scm\Executor;

use Scm\Executor\Executor;
use Scm\Exception\PathNotFoundException;
use Scm\Executor\LogEntry;
use Scm\Filesystem\Directory;

abstract class Command extends Executor
{
    protected $process;
    protected $directory;
    protected $options;

    public function __construct($directory, array $options=array())
    {
        parent::__construct();

        $this->process = null;
        $this->directory = $directory;
        $this->options = array_merge(array(
            'verbose' => true,
        ), $options);
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function __toString()
    {
        return get_class($this);
    }

    protected function runProcess($command, $callback)
    {
        $this->process = new Process($command, $this->directory);
        $code = $this->process->run($callback);

        if($code === 0) {
            $this->log->add(get_class($this).' command successfully executed in '.$this->directory, LogEntry::SUCCESS);
            return true;
        }

        $this->log->add(get_class($this).' command execution failed in '.$this->directory.' with error ('.$this->process->getExitCode().') '.$this->process->getErrorOutput(), LogEntry::SUCCESS);
        return false;
    }

    protected function makeDirectory($directory=null, $mode=0755)
    {
        return mkdir(is_null($directory) ? $this->directory : $directory, $mode, true);
    }

    protected function removeFiles($directory, array $matches=array())
    {
        $dir = new Directory($directory);
        $dir->removeFiles($matches);
    }

    protected function getRealPath($path)
    {
        $real = static::$env->getRealPath($path);

        if(! realpath($real)) {
            $this->log->add(LogEntry::ERROR, 'Path "'.$real.'" not found');

            if(! $this->options['fail-silently']) {
                throw new PathNotFoundException($real);
            }

            return null;
        }

        return $real;
    }

    protected function getRealRepository($repository)
    {
        return static::$env->getRealRepository($repository);
    }

    protected function getRealBranch($branch)
    {
        return static::$env->getRealBranch($branch);
    }
}