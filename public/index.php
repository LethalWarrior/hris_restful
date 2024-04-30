<?php

// Load configs

use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;
use Phalcon\Di\FactoryDefault;
use App\Controllers\ErrorController;
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

$app->notFound(function () {
    $response = new Response();
    $response->setStatusCode(404, 'Not Found');
    $response->setJsonContent(['error' => 'Resource not found']);
    return $response;
});

$app->handle();
