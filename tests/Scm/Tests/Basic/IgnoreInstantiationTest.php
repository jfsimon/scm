<?php

namespace Scm\Tests\Basic;

use Scm\Tests\ScmTestCase;
use Scm\Ignore\GitIgnore;

class IgnoreInstantiationTest extends ScmTestCase
{
    public function testGitIgnoreInstantiation()
    {
        $ign = new GitIgnore($this->makeTestDirectory());
    }
}