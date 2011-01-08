Control your SCM with PHP
=========================

**Biohazard : untested library, don't use at home**

*This library is under active developpement, it's just a draft for now ;
feel free to tell how you feel with this architecture, the debate is wild open.*


What is the goal ?
------------------

The goal is to get a library with *simple* commands to *basicaly* manage repositories.

I think it could start by handling Git, Subversion and Mercurial.


How to use current implementation ?
-----------------------------------

An exemple:

    $repos = Repository::git('/path/to/my/folder', array('verbose' => false))
        ->setEnv(array('repository' => 'http://my/ditant/repository.git', 'branch' => 'master'))
        ->fetch()
        ->add('.')
        ->commit();
        
        
Executor classes
----------------

`Command` and `Repository` classes are `Executor`. Each `Executor` classes provide $log and $env public member.


###Log class

Log class is used to log all that append. Feel free to write this into a file or echo from a command line task.


###Env class

Env class handle environment and is used to:

-  Store current distant repository
-  Store current branch
-  Store aliases for directories and repositories
        
        
One class to rule them all
--------------------------

The main class is the `Repository` class, it represents a local repository.

###Available commands

-  **create**(): creates the repository (if not exists)
-  **fetch**($repository, $branch=null): fetches a distant repository
-  **add**($file): adds a file or directory to SCM control
-  **commit**($message='no message', $repository=null, $branch=null): commits current state to distant repository
-  **unsuscribe**(): removes all SCM files
-  **mutate**($system): switch from current SCM to given SCM
-  **move**($directory): moves local repository to given directory