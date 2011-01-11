<?php

namespace Scm\Tests\Basic;

use Scm\Tests\ScmTestCase;
use Scm\Executor\Log;
use Scm\Executor\Env;

class ExecutorInstantiationTest extends ScmTestCase
{
    public function testGitIgnoreInstantiation()
    {
        $log = new Log();
        $env = new Env();
    }
}