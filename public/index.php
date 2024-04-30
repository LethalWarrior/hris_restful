<?php

// Load configs
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Postgresql;

// Autoload
require __DIR__ . '/../config/loader.php';

// Initialize DI Container
$di = require __DIR__ . '/../config/di.php';

// Initialize App
$app = new Micro($di);

// Include routes
$userRoutes = include __DIR__ . '/../app/routes/userRoutes.php';
$app->mount($userRoutes);

$app->handle();
