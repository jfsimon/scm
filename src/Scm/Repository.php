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
    protected $options;

    public function __construct($system, $directory, array $options=array(), $processCallback=null)
    {
        $this->log = new Log();

        $this->system = $system;
        $this->directory = $directory;

        $this->processCallback = $processCallback;
        $this->options = array_merge(array(
            'fail-silently' => false,
            'verbose' => true,
        ), $options);
    }

    static public function git($directory, array $options=array(), $processCallback=null)
    {
        return new self(self::GIT, $directory, $options, $processCallback);
    }

    static public function subversion($directory, array $options=array(), $processCallback=null)
    {
        return new self(self::SUBVERSION, $directory, $options, $processCallback);
    }

    static public function mercurial($directory, array $options=array(), $processCallback=null)
    {
        return new self(self::MERCURIAL, $directory, $options, $processCallback);
    }

    public function create()
    {
        return $this->callCommand('create', $this->options);
    }

    public function fetch($repository, $branch=null)
    {
        return $this->callCommand('fetch', $this->options, array(
            'repository' => $repository,
            'branch' => $branch
        ));
    }

    public function add($directory)
    {
        return $this->callCommand('add', $this->options, array(
            'directory' => $directory
        ));
    }

    public function commit($message, $branch=null)
    {
        return $this->callCommand('commit', $this->options, array(
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

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    protected function getCommand($command)
    {
        $class = 'Scm\Command\\'.$this->system.'\\'.ucfirst($command);
        return new $class($this->directory);
    }

    protected function callCommand($name, array $options, array $parameters=array())
    {
        $command = $this->getCommand($name, $options);

        foreach($parameters as $name => $value) {
            $method = 'set'.ucfirst($name);
            $command->$method($value);
        }

        $success = $command->execute($this->processCallback);

        if(! $this->options['fail-silently']) {
            throw new CommandFailedException($command, $command->log);
        }

        $this->log->merge($command->log);

        return $this;
    }
}