<?php

use Phalcon\Loader;

$loader = new Loader();
$loader->registerNamespaces([
    'App\Models' => realpath(__DIR__ . '/../app/models/'),
]);

$loader->register();
