<?php

namespace Scm\Env;

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

    public function setAlias($aliases, $value)
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