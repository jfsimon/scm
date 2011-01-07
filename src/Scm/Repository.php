<?php

namespace Scm;

use Scm\Exception\CommandFailedException;
use Scm\Log\Log;

class Repository
{
    const GIT = 'Git';
    const SUBVERSION = 'Subversion';
    const MERCURIAL = 'Mercurial';

    public $log;

    protected $system;
    protected $directory;

    protected $processCallback;
    protected $failSilently;

    public function __construct($system, $directory, $processCallback=null, $failSilently=false)
    {
        $this->log = new Log();

        $this->system = $system;
        $this->directory = $directory;

        $this->processCallback = $processCallback;
        $this->failSilently = $failSilently;
    }

    static public function git($directory, $processCallback=null, $failSilently=false)
    {
        return new self(self::GIT, $directory, $processCallback, $failSilently);
    }

    static public function subversion($directory, $processCallback=null, $failSilently=false)
    {
        return new self(self::SUBVERSION, $directory, $processCallback, $failSilently);
    }

    static public function mercurial($directory, $processCallback=null, $failSilently=false)
    {
        return new self(self::MERCURIAL, $directory, $processCallback, $failSilently);
    }

    public function create()
    {
        return $this->callCommand('create');
    }

    public function fetch($repository, $branch=null)
    {
        return $this->callCommand('fetch', array(
            'repository' => $repository,
            'branch' => $branch
        ));
    }

    public function add($directory)
    {
        return $this->callCommand('add', array(
            'directory' => $directory
        ));
    }

    public function commit($message, $branch=null)
    {
        return $this->callCommand('commit', array(
            'message' => $message,
            'branch' => $branch
        ));
    }

    public function getProcessCallback()
    {
        return $this->processCallback;
    }

    public function setProcessCallback($processCallback)
    {
        $this->processCallback = $processCallback;
    }

    public function getFailSilently()
    {
        return $this->failSilently;
    }

    public function setFailSilently($failSilently)
    {
        $this->failSilently = $failSilently;
    }

    protected function getCommand($command)
    {
        $class = 'Scm\Command\\'.$this->system.'\\'.ucfirst($command);
        return new $class($this->directory);
    }

    protected function callCommand($name, array $parameters=array())
    {
        $command = $this->getCommand($name);

        foreach($parameters as $name => $value) {
            $method = 'set'.ucfirst($name);
            $command->$method($value);
        }

        $success = $command->execute($this->processCallback);

        if(! $this->failSilently) {
            throw new CommandFailedException($command, $command->log);
        }

        $this->log->merge($command->log);

        return $this;
    }
}