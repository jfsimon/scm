<?php

namespace Scm\Filesystem;

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

    public function move($directory)
    {
        rename($this->directory, $this->getRealDirectory($directory));
    }

    public function copy($directory)
    {
        self::copyDirectory($this->directory, $this->getRealDirectory($directory));
    }

    public function remove($directory=null)
    {
        self::removeDirectory($this->getRealDirectory($directory));
    }

    public function removeFiles(array $matches=array(), $directory=null)
    {
        $finder = new Finder();
        $finder->files()->in($this->getRealDirectory($directory));

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
        $finder->directories()->in($this->getRealDirectory($directory));

        foreach($finder as $dir) {
            if($this->isEmpty($dir)) {
                rmdir($dir);
            }
        }
    }

    public function isEmpty($directory=null)
    {
        $finder = new Finder();
        $finder->in($this->getRealDirectory($directory));

        foreach($finder as $file) {
            return false;
        }

        return true;
    }

    public function getPath()
    {
        return $this->directory;
    }

    public function __toString()
    {
        return $this->getPath();
    }

    public static function copyDirectory($from, $to)
    {
        if(! file_exists($to)) {
            mkdir($to);
        };

        $handle = opendir($from);

        while($item = readdir($handle)) {
            if($item=="." | $item=="..") continue;

            if(is_dir($from.'/'.$item)) {
                self::copyDirectory($from.'/'.$item, $to.'/'.$item);
            } else {
                copy($from.'/'.$item, $to.'/'.$item);
            }
        }

        closedir($handle);
    }

    public static function removeDirectory($dir)
    {
        if(! file_exists($dir)) {
            return;
        };

        $handle = opendir($dir);

        while($item = readdir($handle)) {
            if($item=="." | $item=="..") continue;

            if(is_dir($dir.'/'.$item)) {
                self::removeDirectory($dir.'/'.$item);
            } else {
                unlink($dir.'/'.$item);
            }
        }

        rmdir($dir);
        closedir($handle);
    }

    protected function getRealDirectory($directory)
    {
        return is_null($directory) ? $this->directory : (substr($directory, 0, 1) === '/' ? $directory : $this->directory.'/'.$directory);
    }
}