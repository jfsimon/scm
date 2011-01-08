<?php

namespace Scm\Ignore;

abstract class Ignore implements \IteratorAggregate
{
    protected $directory;
    protected $cache;

    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->cache = array();
    }

    public function add($mask)
    {
        if(in_array($mask, $this->cache)) {
            return;
        }

        $this->cache[] = $mask;

        $this->writeOne($mask);
    }

    public function remove($mask)
    {
        if(! in_array($mask, $this->cache)) {
            return;
        }

        unset($this->cache[array_search($mask, $this->cache)]);

        $this->removeOne($mask);
    }

    public function getIterator()
    {
        return $this->cache;
    }

    public function all()
    {
        return $this->cache;
    }

    abstract protected function writeOne($mask);
    abstract protected function removeOne($mask);
}