<?php

namespace Scm\Executor;

class LogEntry
{
    const SUCCESS = 'success';
    const INFO = 'info';
    const ERROR = 'error';

    protected $message;
    protected $type;
    protected $timestamp;

    public function __construct($type, $message, $timestamp=null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->timestamp = is_null($timestamp) ? time() : $timestamp;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function __toString()
    {
        return date('c', $this->timestamp).' ['.strtoupper($this->type).'] '.$this->message;
    }
}