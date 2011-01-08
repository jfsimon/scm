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

        $this->ignore = $this->getIgnore();

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

    public function create()
    {
        return $this->callCommand('create', $this->options);
    }

    public function fetch($repository=null, $branch=null)
    {
        return $this->callCommand('fetch', $this->options, array(
            'repository' => $repository,
            'branch' => $branch
        ));
    }

    public function add($file)
    {
        return $this->callCommand('add', $this->options, array(
            'file' => $file
        ));
    }

    public function commit($message='no message', $repository=null, $branch=null)
    {
        return $this->callCommand('commit', $this->options, array(
            'message' => $message,
            'repository' => $repository,
            'branch' => $branch
        ));
    }

    public function unsuscribe()
    {
        return $this->callCommand('unsuscribe', $this->options);
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

    protected function getIgnore()
    {
        $class = 'Scm\Ignore\\'.$this->system.'Ignore';
        return new $class($this->directory);
    }

    protected function getCommand($command)
    {
        $class = 'Scm\Command\\'.$this->system.'\\'.ucfirst($command);
        return new $class($this->directory);
    }

    protected function callCommand($name, array $options=array(), array $parameters=array())
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