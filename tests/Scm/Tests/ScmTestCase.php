<?php

namespace Scm\Tests;

use Symfony\Component\Finder\Finder;
use Scm\Filesystem\Directory;

class ScmTestCase extends \PHPUnit_Framework_TestCase
{
    const TEST_DIRECTORY = '/tmp/scm-tests';

    protected function makeTestDirectory()
    {
        $directory = self::TEST_DIRECTORY;

        if(realpath($directory)) {
            $dir = new Directory($directory);
            $dir->remove();
        }

        mkdir($directory);

        return $directory;
    }

    protected function getClassesByNamespace($namespace)
    {
        $directory = realpath(__DIR__.'/../../../src/'.str_replace('\\', '/', $namespace));

        $classes = array();
        $finder = new Finder();

        $finder
            ->files()
            ->name('*.php')
            ->in($directory)
        ;

        foreach($finder as $filename) {
            $classes[] = $namespace.'\\'.substr(substr($filename, 0, strrpos($filename, '.')), strrpos($filename, '/') + 1);
        }

        return $classes;
    }

    protected function makeTestDirectoryStructure()
    {
        $directory = self::DATA_DIR.'/directory';
        copy($directory, $this->makeTestDirectory());

        return $directory;
    }
}