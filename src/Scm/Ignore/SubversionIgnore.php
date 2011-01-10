<?php

namespace Scm\Ignore;

class SubversionIgnore extends Ignore implements IgnoreInterface, \IteratorAggregate
{
    public function read()
    {
        $this->cache = array();

        foreach($this->getFiles() as $filename) {
            $file = new StringsFile($filename);
            $this->cache = array_merge($this->cache, $file->read());
        }
    }

    public function write()
    {
        foreach($this->parseMasks($this->cache) as $filename => $masks) {
            $file = new StringsFile($filename);
            $file->write($masks, true, true);
        }
    }

    protected function writeOne($mask)
    {
        $data = $this->parseMask($mask);

        $file = new StringsFile($data['filename']);
        $file->append($data['mask'], true);
    }

    protected function removeOne($mask)
    {
        $data = $this->parseMask($mask);

        $file = new StringsFile($data['filename']);
        $file->remove($data['mask']);
    }

    protected function parseMask($mask)
    {
        return array('mask' => $mask, 'filename' => $mask);
    }

    protected function parseMasks(array $masks)
    {
        return array();
    }

    protected function getFiles()
    {
        return array();
    }
}