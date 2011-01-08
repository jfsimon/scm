<?php

namespace Scm\Tests\Basic;

use Scm\Tests\ScmTestCase;
use Scm\Repository;

class RepositoryInstantiationTest extends ScmTestCase
{
    public function testGitRepositoryInstantiation()
    {
        $repository = new Repository(Repository::GIT, '/tmp');
    }

//    public function testSubversionRepositoryInstantiation()
//    {
//        $repository = new Repository(Repository::SUBVERSION, '/tmp');
//    }
//
//    public function testMercurialRepositoryInstantiation()
//    {
//        $repository = new Repository(Repository::MERCURIAL, '/tmp');
//    }
}