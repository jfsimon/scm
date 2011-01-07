Control your SCM with PHP
=========================

**Note 1 : this library is under active developpement, it's just a draft for now.**

**Note 2 : feel free to tell how you feel with this architecture, the debate is open.**


What is the goal ?
------------------

The goal is to get a library with *simple* commands to *basicaly* manage repositories.

I think it could start by handling Git, Subversion and Mercurial.


How to use current implementation ?
-----------------------------------

An exemple :

    $url = 'http://my/ditant/repository.git';

    $repos = Repository::git('/path/to/my/folder')
        ->fetch($url)
        ->add('.')
        ->commit($url);