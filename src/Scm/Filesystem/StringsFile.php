<?php

namespace Scm\Filesystem;

class StringsFile implements \IteratorAggregate
{
    protected $file;

    public function __construct($file, $force=false, $autoClean=false, $uniqueClean=false)
    {
        if(! file_exists($file)) {
            if($force) {
                touch($file);
            } else {
                throw new \RuntimeException('file "'.$file.'" does not exixts');
            }
        }

        if(is_dir($file)) {
            if($force) {
                $dir = new Directory($file);
                $dir->remove();
            } else {
                throw new \RuntimeException('cannot open file : "'.$file.'" is a directory');
            }
        }

        $this->file = $file;

        if($autoClean) {
            $this->clean($uniqueClean);
        }
    }

    public function getIterator()
    {
        return $this->read();
    }

    public function read()
    {
        return file($this->file);
    }

    public function contains($string)
    {
        return in_array($string, $this->read());
    }

    public function append($string, $ifNotExists=true)
    {
        if($ifNotExists && $this->contains($string)) {
            return;
        }

        $strings = $this->read();
        $strings[] = $string;

        $this->write($strings);
    }

    public function remove($string)
    {
        $strings = array();
        $count = 0;

        foreach($this->read() as $row) {
            if($row !== $string) {
                $strings[] = $row;
            } else {
                $count ++;
            }
        }

        $this->write($strings);
        return $count;
    }

    public function clean($unique=false)
    {
        $this->write($this->cleanStrings($this->read(), $unique));
    }

    public function unique()
    {
        $this->write(array_unique($this->read()));
    }

    public function write(array $strings, $autoClean=false, $uniqueClean=false)
    {
        if($autoClean) {
            $strings = $this->cleanStrings($strings, $uniqueClean);
        }

        file_put_contents($this->file, implode("\n", $strings));
    }

    public function move($file, $force=false)
    {
        if(file_exists($file)) {
            if($force) {
                if(is_dir($file)) {
                    $dir = new Directory($file);
                    $dir->unlink();
                } else {
                    unlink($file);
                }
            } else {
                throw new \RuntimeException('destination file "'.$file.'" already exists');
            }
        }

        if(! rename($this->file, $file)) {
            throw new \RuntimeException('cannot move file "'.$this->file.'" to "'.$file.'"');
        }

        $this->file = $file;
    }

    public function unlink()
    {
        unlink($this->file);
    }

    protected function cleanStrings(array $strings, $unique=false)
    {
        $cleaned = array();

        foreach($strings as $string) {
            $temp = trim($string);

            if(strlen($temp)) {
                $cleaned[] = $temp;
            }
        }

        if($unique) {
            $cleaned = array_unique($cleaned);
        }

        return $cleaned;
    }
}