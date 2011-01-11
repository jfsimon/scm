<?php

namespace Scm\Tests\Basic;

use Scm\Tests\ScmTestCase;

class CommandsInstantiationTest extends ScmTestCase
{
    public function testGitCommandsInstantiation()
    {
        $this->intanciateClasses('Scm\Command\Git');
    }

    protected function intanciateClasses($namespace)
    {
        foreach($this->getClassesByNamespace($namespace) as $classname) {
            $instance = new $classname($this->makeDirectory());
        }
    }


}