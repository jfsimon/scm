Control your SCM with PHP
=========================

A cross SCM systems (Git, Subversion, Mercurial) abstraction library written in PHP.

**Biohazard : untested library, don't use at home**

*This library is under active developpement, it's just a draft for now ;
feel free to tell how you feel with this architecture, the debate is wild open.*


Currently implemented
---------------------




How to use current implementation ?
-----------------------------------

An exemple:

    $repos = new Repository(Repôsitory::GIT, '/path/to/my/folder', array('verbose' => false));
    
    $repos
        ->setEnv(array('repository' => 'http://my/ditant/repository.git', 'branch' => 'master'))
        ->fetch()
        ->add('.')
        ->commit()
    ;
    
**Run the tests:** just launch `phpunit` in the root directory.
        
        
Executor classes
----------------

`Command` and `Repository` classes are `Executor`. Each `Executor` class provide $log and $env public member.


###Log class

Log class is used to log all that append. Feel free to write this into a file or echo from a command line task.


###Env class (shared)

Env class handle environment and is used to:

-  Store current distant repository
-  Store current branch
-  Store aliases for directories and repositories
        
        
One class to rule them all
--------------------------

The `Repository` class represents a local repository and is the start point for all your needs.

###Available commands

-  `**create**()`: creates the repository (if not exists)
-  `**fetch**($repository, $branch=null)`: fetches a distant repository
-  `**add**($file)`: adds a file or directory to SCM control
-  `**commit**($message='no message', $repository=null, $branch=null)`: commits current state to distant repository
-  `**unsuscribe**()`: removes all SCM files
-  `**mutate**($system)`: switch from current SCM to given SCM
-  `**move**($directory)`: moves local repository to given directory