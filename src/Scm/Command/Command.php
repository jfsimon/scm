<?php

namespace Scm\Command;

use Scm\Log\Log;
use Scm\Log\LogEntry;

abstract class Command
{
    public $log;
    protected $directory;

    public function __construct($directory)
    {
        $this->log = new Log();
        $this->directory = $directory;
    }

    public function getDirectory()
    {
        return $this->directory;
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