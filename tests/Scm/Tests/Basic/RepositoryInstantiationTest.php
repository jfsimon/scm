<?php

namespace Scm\Tests\Basic;

use Scm\Tests\ScmTestCase;
use Scm\Repository;

class RepositoryInstantiationTest extends ScmTestCase
{
    public function testGitRepositoryInstantiation()
    {
        $repository = new Repository(Repository::GIT, $this->makeTestDirectory());
    }
}