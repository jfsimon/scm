<?php

namespace Scm\Tests\Filesystem;

use Scm\Filesystem;

use Scm\Tests\ScmTestCase;
use Scm\Filesystem\Directory;

class DirectoryTest extends ScmTestCase
{
    public function testMake()
    {
        $directory = $this->makeTestDirectoryStructure();
        $this->assertTrue(file_exists($directory));
        $this->assertTrue(is_dir($directory));
    }

    public function testRemove()
    {
        $directory = $this->makeTestDirectoryStructure();
        $dir = new Directory($directory);
        $dir->remove();
        $this->assertFalse(file_exists($directory));
    }

    public function testIsEmpty()
    {
        $directory = $this->makeTestDirectoryStructure();
        $dir = new Directory($directory);
        $this->assertFalse($dir->isEmpty('folder1/folder11'));
        $this->assertTrue($dir->isEmpty('folder1/folder12'));
        $this->assertTrue($dir->isEmpty('folder1/folder13'));
    }

    public function testRemoveFiles()
    {
        $directory = $this->makeTestDirectoryStructure();
        $dir = new Directory($directory);
        $dir->removeFiles(array(), 'folder2');
        $this->assertTrue($dir->isEmpty('folder2'));
    }

    public function testRemoveFilesMatches()
    {
        $directory = $this->makeTestDirectoryStructure();
        $dir = new Directory($directory);
        $dir->removeFiles(array('file1*'));
        $this->assertTrue(file_exists($directory.'/folder2/file21'));
        $this->assertFalse(file_exists($directory.'/folder1/file11'));
        $this->assertFalse(file_exists($directory.'/folder1/folder11/file111'));
    }

    public function testRemoveEmptyDirectories()
    {
        $directory = $this->makeTestDirectoryStructure();
        $dir = new Directory($directory);
        $dir->removeEmptyDirectories('folder1');
        $this->assertTrue(file_exists($directory.'/folder1/folder11'));
        $this->assertFalse(file_exists($directory.'/folder1/folder12'));
        $this->assertFalse(file_exists($directory.'/folder1/folder13'));
    }

    public function testRemoveDirectory()
    {
        $directory = $this->makeTestDirectoryStructure();
        $dir = new Directory($directory);
        $dir->remove('folder1');
        $this->assertFalse(file_exists($directory.'/folder1'));
    }

    public function testMove()
    {
        $directory = $this->makeTestDirectoryStructure();
        $directory2 = '/tmp/scm-tests-2';
        $dir = new Directory($directory2);
        $dir->remove();
        $dir = new Directory($directory);
        $dir->move($directory2);
        $this->assertFalse(file_exists($directory));
        $this->assertTrue(file_exists($directory2));
        $this->assertTrue(is_dir($directory2));
    }
}