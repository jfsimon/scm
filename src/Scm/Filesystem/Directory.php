<?php

namespace Scm\Filesystem;

class Directory
{
    protected $directory;

    public function __construct($directory)
    {
        if(! file_exists($directory)) {
            throw new \RuntimeException('directory "'.$directory.'" does not exixts');
        }

        if(! is_dir($directory)) {
            throw new \RuntimeException('"'.$directory.'" is not a directory');
        }

        $this->directory = realpath($directory);
    }

    public function remove($masks)
    {
        if(is_null($mask)) {
            $this->removeDirectory($this->directory);
        } else {

        }
    }

    public function move($directory)
    {

    }

    protected function removeDirectory($directory)
    {

    }
}