<?php

namespace Scm\Tests\Command;

use Scm\Filesystem;

use Scm\Tests\ScmTestCase;
use Scm\Filesystem\Directory;
use Scm\Command\Git\Fetch;

class FetchTest extends ScmTestCase
{
    public function testGitFetch()
    {
        $repos = 'git://github.com/jfsimon/scm.git';
        $dir = new Directory($this->makeTestDirectory());
        $fetch = new Fetch($dir->getPath());
        $fetch->setRepository($repos);
        $fetch->execute();
        $this->assertFalse($dir->isEmpty());
        $this->assertEquals($repos, file_get_contents($dir->getPath().'/data/tests/repository'));
        $dir->remove();
    }
}