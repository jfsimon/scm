<?php

namespace Scm\Ignore;

class GitIgnore extends Ignore implements IgnoreInterface, \IteratorAggregate
{
    protected $file;

    public function __construct($directory)
    {
        parent::__construct($directory);
        $this->file = new StringsFile($this->directory.DIRECTORY_SEPARATOR.'.gitignore');
    }

    public function read()
    {
        $this->cache = $this->file->read();
    }

    public function write()
    {
        $this->file->write($this->cache, true, true);
    }

    protected function writeOne($mask)
    {
        $this->file->append($mask, true);
    }

    protected function removeOne($mask)
    {
        $this->file->remove($mask);
    }
}