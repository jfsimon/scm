<?php

namespace Scm\Ignore;

use Scm\Filesystem\StringsFile;

class GitIgnore extends Ignore implements IgnoreInterface, \IteratorAggregate
{
    protected $file;

    public function __construct($directory)
    {
        parent::__construct($directory);
        $this->file = $directory.DIRECTORY_SEPARATOR.'.gitignore';
    }

    public function read()
    {
        $file = new StringsFile($this->file);
        $this->cache = $file->read();
    }

    public function write()
    {
        $file = new StringsFile($this->file);
        $file->write($this->cache, true, true);
    }

    protected function writeOne($mask)
    {
        $file = new StringsFile($this->file);
        $file->append($mask, true);
    }

    protected function removeOne($mask)
    {
        $file = new StringsFile($this->file);
        $file->remove($mask);
    }
}