<?php

namespace Scm\Ignore;

interface IgnoreInterface
{
    public function __construct($directory);
    public function read();
    public function all();
    public function add($mask);
    public function remove($mask);
    public function write();
}