<?php

require_once __DIR__.'/vendor/Symfony/Component/HttpFoundation/UniversalClassLoader.php';

use Symfony\Component\HttpFoundation\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Scm\Test' => __DIR__.'/../tests/',
    'Scm'     => __DIR__,
    'Symfony' => __DIR__.'/vendor',
));
$loader->register();