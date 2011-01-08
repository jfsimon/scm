<?php

namespace Scm\Executor;

class Env
{
    protected $aliases;
    protected $repository;
    protected $branch;

    public function __construct()
    {
        $this->aliases = array();
        $this->repository = null;
        $this->branch = null;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function getAlias($alias, $default=null)
    {
        return isset($this->aliases[$alias]) ? $this->aliases[$alias] : $default;
    }

    public function getRepository($repository=null)
    {
        return $repository ? $repository : $this->repository;
    }

	public function getBranch($branch=null)
    {
        return $branch ? $branch : $this->branch;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }

    public function setAlias($alias, $value)
    {
        $this->aliases[$alias] = $value;
    }

	public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    public function setBranch($branch)
    {
        $this->branch = $branch;
    }



}