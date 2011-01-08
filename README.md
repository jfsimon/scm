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

An exemple :

    $repos = Repository::git('/path/to/my/folder', array('verbose' => false))
        ->setEnv(array('repository' => 'http://my/ditant/repository.git', 'branch' => 'master'))
        ->fetch()
        ->add('.')
        ->commit();