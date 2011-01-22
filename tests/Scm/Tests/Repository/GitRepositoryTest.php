<?php

namespace Scm\Tests\Command;

use Scm\Tests\ScmTestCase;
use Scm\Filesystem\Directory;
use Scm\Repository;

class FetchTest extends ScmTestCase
{
    public function testFetch()
    {
        $uri = 'git://github.com/jfsimon/scm.git';
        $dir = new Directory($this->makeTestDirectory());
        $repos = new Repository(Repository::GIT, $dir);
        $repos->fetch($uri);
        $this->assertFalse($dir->isEmpty());
        $this->assertEquals($uri, file_get_contents($dir->getPath().'/data/tests/repository'));
        $dir->remove();
    }
}