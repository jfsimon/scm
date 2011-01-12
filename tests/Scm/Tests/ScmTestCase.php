<?php

namespace Scm\Tests;

use Symfony\Component\Finder\Finder;
use Scm\Filesystem\Directory;

class ScmTestCase extends \PHPUnit_Framework_TestCase
{
    protected $dataDir;
    protected $testDir;

    public function __construct($name=null)
    {
        parent::__construct($name);

        $this->dataDir = realpath(__DIR__.'/../../../data/tests');
        $this->testDir = '/tmp/scm-tests';
    }

    protected function makeTestDirectory()
    {
        $directory = $this->testDir;

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
        $directory = $this->makeTestDirectory();

        $dir = new Directory($this->dataDir.'/directory');
        $dir->copy($this->makeTestDirectory());

        mkdir($directory.'/folder1/folder12');
        mkdir($directory.'/folder1/folder13');

        return $directory;
    }

    protected function makeTestStringsFileStructure()
    {
        $directory = $this->dataDir.'/strings';
        copy($directory, $this->makeTestDirectory());

        return $directory;
    }
}