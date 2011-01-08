<?php

namespace Scm\Ignore;

class GitIgnore extends Ignore implements IgnoreInterface, \IteratorAggregate
{
    public function read()
    {
        $file = new StringsFile($this->getIgnoreFile());
        $this->cache = $file->read();
    }

    public function write()
    {
        $file = new StringsFile($this->getIgnoreFile());
        $file->write($this->cache, true, true);
    }

    protected function writeOne($mask)
    {
        $file = new StringsFile($this->getIgnoreFile());
        $file->append($mask, true);
    }

    protected function removeOne($mask)
    {
        $file = new StringsFile($this->getIgnoreFile());
        $file->remove($mask);
    }

    protected function getIgnoreFile()
    {
        return $this->directory.DIRECTORY_SEPARATOR.'.gitignore';
    }
}