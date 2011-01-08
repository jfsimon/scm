<?php

namespace Scm\Filesystem;

use Symfony\Component\Finder;

use Symfony\Component\Finder\Finder;

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

    public function remove()
    {
        $this->removeDirectory();
    }

    public function move($directory)
    {
        rename($this->directory, $this->getDirectory($directory));
    }

    public function removeDirectory($directory=null)
    {
        $finder = new Finder();
        $finder->in($this->getDirectory($directory));

        foreach($finder->files() as $file) {
            unlink($file);
        }

        foreach($finder->directories() as $dir) {
            rmdir($dir);
        }

        rmdir($directory);
    }

    public function removeFiles(array $matches=array(), $directory=null)
    {
        $finder = new Finder();
        $finder->files()->in($this->getDirectory($directory));

        foreach($matches as $match) {
            $finder->name($match);
        }

        foreach($finder as $file) {
            unlink($file);
        }
    }

    public function removeEmptyDirectories($directory=null)
    {
        $finder = new Finder();
        $finder->directories()->in($this->getDirectory($directory));

        foreach($finder as $dir) {
            if($this->isEmptyDirectory($dir)) {
                rmdir($dir);
            }
        }
    }

    public function isEmptyDirectory($directory=null)
    {
        $finder = new Finder();
        $finder->in($this->getDirectory($directory));

        foreach($finder as $file) {
            return false;
        }

        return true;
    }

    protected function getDirectory($directory)
    {
        return is_null($directory) ? $this->directory : (substr($directory, 0, 1) === '/' ? $directory : $this->directory.'/'.$directory);
    }
}