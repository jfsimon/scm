Control your SCM with PHP
=========================

A cross SCM systems (Git, *Subversion*, *Mercurial*) abstraction library written in PHP.

**Biohazard : untested library, don't use at home**

**Only Git SCM is supported for now**

*This library is under active developpement, it's just a draft for now ;
feel free to tell how you feel with this architecture, the debate is wild open.*


How to use current implementation ?
-----------------------------------

An exemple:

    $repos = new Repository(Repository::GIT, '/path/to/my/folder', array('verbose' => false));
    
    $repos
        ->setEnv(array('repository' => 'http://my/ditant/repository.git', 'branch' => 'master'))
        ->fetch()
        ->add('.')
        ->commit()
    ;
    
**Run the tests:** just launch `phpunit` in the root directory.
        
        
One class to rule them all
--------------------------

The `Repository` class represents a local repository and is the start point for all your needs.


###Available commands

The control commands are chainable (they return $this).

-  `create()`: creates the repository (if dont exists)
-  `fetch($repository, $branch=null)`: fetches a distant repository
    -  if the local repository dont exists, this command clone the distant repository
    -  if the local repository exists, this command just updates it
    -  if another branch than the current branch in the existing local repository is specified, this command checkouts the branch
-  `add($file='.')`: adds a file or directory to SCM control
-  `sub($path='.')`: removes a file or directory from SCM control
-  `clean($path='.')`: adds modified files and subs deleted files
-  `commit($message='no message', $repository=null, $branch=null)`: commits current state to distant repository
-  `unsuscribe()`: removes all SCM files
-  `mutate($system)`: switch from current SCM to given SCM
-  `move($directory)`: moves local repository to given directory
-  `revert($version=null)`: reverts to specified version, if none specified, reverts to the last one


###Status methods

Following status informations are available from the `Repository` class.

-  `getBranches($repository)`: returns available branches from the given repository
-  `getModifiedFiles()`: returns the modified files list
-  `getDeletedFiles()`: returns the deleted files list
-  `getUntrackedFiles()`: returns the untracked files list
-  `getCommits()`: returns the commits history


Notes about the differents SCM
------------------------------


###Git

*To be continued*


###Subversion

*To be continued*


###Mercurial

*To be continued*


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
