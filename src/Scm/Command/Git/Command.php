<?php

namespace Scm\Command\Git;

use Scm\Command\Command as BaseCommand;

class Command extends BaseCommand
{
    protected function isRepository($directory=null)
    {
        $directory = is_null($directory) ? $this->directory : $directory;
        $test = $directory.DIRECTORY_SEPARATOR.'.git';

        return file_exists($test) && is_dir($test);
    }
}