<?php

namespace Scm\Tests\Basic;

use Scm\Tests\ScmTestCase;
use Scm\Filesystem\Directory;
use Scm\Filesystem\StringsFile;

class FilesystemInstantiationTest extends ScmTestCase
{
    public function testInstantiations()
    {
        $directory = $this->makeTestDirectory();
        $file = $directory.'/empty-file';
        touch($file);

        $dir = new Directory($directory);
        $stf = new StringsFile($file);
    }
}