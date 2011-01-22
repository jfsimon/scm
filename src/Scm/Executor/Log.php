<?php

namespace Scm\Executor;

use Scm\Executor\LogEntry;

class Log implements \IteratorAggregate
{
    protected $entries;

    public function __construct()
    {
        $this->entries = array();
    }

    public function add($message, $type=LogEntry::INFO)
    {
        $this->entries[] = new LogEntry($type, $message);
    }

    public function merge(Log $log)
    {
        foreach($log as $entry) {
            $this->add($entry);
        }

        $this->order();
    }

    public function hasError()
    {
        foreach($this->entries as $entry) {
            if($entry->getType() === LogEntry::ERROR) {
                return true;
            }
        }

        return false;
    }

    public function compareEntries(LogEntry $a, LogEntry $b)
    {
        return $a->getTimestamp() > $b->getTimestamp();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->entries);
    }

    public function __toString()
    {
        $strings = array();

        foreach($this->entries as $entry) {
            $strings[] = $entry->__toString();
        }

        return implode("\n", $strings);
    }

    protected function order()
    {
        usort($this->entries, array($this, 'compareEntries'));
    }
}