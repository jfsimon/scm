<?php

namespace Scm\Command;

interface CommandInterface
{
    public function __construct($dierectory);
    public function execute($processCallback=null);
    public function __toString();
}