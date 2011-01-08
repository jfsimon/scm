<?php

namespace Scm\Command;

use Scm\Executor\Executor;

abstract class Command extends Executor
{
    protected $directory;
    protected $options;

    public function __construct($directory, array $options=array())
    {
        parent::__construct();

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
        $process = new Process($command, $this->directory);
        $code = $process->run($callback);

        if($code === 0) {
            $this->log->add(get_class($this).' command successfully executed in '.$this->directory, LogEntry::SUCCESS);
            return true;
        }

        $this->log->add(get_class($this).' command execution failed in '.$this->directory.' with error ('.$process->getExitCode().') '.$process->getErrorOutput(), LogEntry::SUCCESS);
        return false;
    }

    protected function makeDirectory($directory=null, $mode=0755)
    {
        return mkdir(is_null($directory) ? $this->directory : $directory, $mode, true);
    }
}