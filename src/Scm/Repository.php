<?php

namespace Scm;

use Scm\Executor\Executor;
use Scm\Exception\CommandFailedException;
use Scm\Executor\LogEntry;

class Repository extends Executor
{
    const GIT = 'Git';
    const SUBVERSION = 'Subversion';
    const MERCURIAL = 'Mercurial';

    public $ignore;

    protected $system;
    protected $directory;
    protected $processCallback;
    protected $options;

    public function __construct($system, $directory, array $options=array(), $processCallback=null)
    {
        parent::__construct();
        $this->system = $system;
        $this->directory = $directory;
        $this->processCallback = $processCallback;

        $this->options = array_merge(array(
            'fail-silently' => false,
            'verbose' => true,
        ), $options);

        $this->ignore = $this->getIgnoreObject();
    }

    public function create()
    {
        $this->callCommand('create', $this->options);

        return $this;
    }

    public function fetch($repository=null, $branch=null)
    {
        $this->callCommand('fetch', $this->options, array(
            'repository' => $repository,
            'branch' => $branch
        ));

        return $this;
    }

    public function add($path=null)
    {
        $this->callCommand('add', $this->options, array(
            'path' => $path
        ));

        return $this;
    }

    public function commit($message='no message', $repository=null, $branch=null)
    {
        $this->callCommand('commit', $this->options, array(
            'message' => $message,
            'repository' => $repository,
            'branch' => $branch
        ));

        return $this;
    }

    public function unsuscribe($path=null)
    {
        $this->callCommand('unsuscribe', $this->options, array(
            'path' => $path
        ));

        return $this;
    }

    public function mutate($system)
    {
        static::$env = new Env();

        $this->ignore->read();
        $this->unsuscribe();
        $this->system = $system;
        $this->create();
        $this->add('.');
        $this->ignore->write();

        return $this;
    }

    public function move($directory, $force=false)
    {
        if(file_exists($directory)) {
            if($force) {
                $this->removeFiles($directory);
            } else {
                $this->runtimeException(LogEntry::ERROR, 'Cannot move repository from "'.$this->directory.'" to existing file "'.$directory.'"');
            }
        }

        if(rename($this->directory, $directory)) {
            $this->directory = $directory;
        }

        return $this;
    }

    public function getBranches()
    {
        return $this->getStatusCommandResult('branches', $this->options);
    }

    public function getCommits()
    {
        return $this->getStatusCommandResult('commits', $this->options);
    }

    public function getModifiedFiles()
    {
        return $this->getInfosCommandResult('status', $this->options, array(
            'section' => 'modified'
        ));
    }

    public function getDeletedFiles()
    {
        return $this->getInfosCommandResult('status', $this->options, array(
            'section' => 'deleted'
        ));
    }

    public function getUntrackedFiles()
    {
        return $this->getInfosCommandResult('status', $this->options, array(
            'section' => 'untracked'
        ));
    }

    public function getProcessCallback()
    {
        return $this->processCallback;
    }

    public function setProcessCallback($processCallback=null)
    {
        $this->processCallback = $processCallback;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function setEnv(array $env=array())
    {
        if(isset($env['repository'])) {
            static::$env->setRepository($env['repository']);
        }

        if(isset($env['branch'])) {
            static::$env->setRepository($env['branch']);
        }

        if(isset($env['aliases'])) {
            static::$env->setAliases($env['aliases']);
        }

        return $this;
    }

    protected function getIgnoreObject()
    {
        $class = 'Scm\Ignore\\'.$this->system.'Ignore';
        return new $class($this->directory);
    }

    protected function getCommandObject($command)
    {
        $class = 'Scm\Command\\'.$this->system.'\\'.ucfirst($command);
        return new $class($this->directory);
    }

    protected function callCommand($name, array $options=array(), array $parameters=array())
    {
        $command = $this->getCommandObject($name, $options);

        foreach($parameters as $name => $value) {
            $method = 'set'.ucfirst($name);
            $command->$method($value);
        }

        $success = $command->execute($this->processCallback);

        if(! ($success || $this->options['fail-silently'])) {
            throw new CommandFailedException($command, $command->log);
        }

        $this->log->merge($command->log);

        return $command;
    }

    protected function getInfosCommandResult($name, array $options=array(), array $parameters=array())
    {
        $name = $name.'Infos';
        $command = $this->callCommand($name, $options, $parameters);

        return $command->getResult();
    }
}