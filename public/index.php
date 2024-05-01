<?php

// Load configs

use App\Middlewares\AuthMiddleware;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;

// Autoload
require __DIR__ . '/../config/loader.php';
require __DIR__ . '/../vendor/autoload.php';

// Initialize DI Container
$di = require __DIR__ . '/../config/di.php';

// Initialize App
$eventsManager = new EventsManager();
$app = new Micro($di);

// Setup Auth Middleware
$excludeAuthURIs = ['/api/login'];
$eventsManager->attach('micro', new AuthMiddleware($excludeAuthURIs));
$app->before(new AuthMiddleware($excludeAuthURIs));

// Setup Role Middleware


$app->setEventsManager($eventsManager);

// Include routes
$authRoutes = include __DIR__ . '/../app/routes/authRoutes.php';
$app->mount($authRoutes);

$userRoutes = include __DIR__ . '/../app/routes/userRoutes.php';
$app->mount($userRoutes);

$app->notFound(function () {
    $response = new Response();
    $response->setStatusCode(404, 'Not Found');
    $response->setJsonContent(['error' => 'Resource not found']);
    return $response;
});

$app->handle();
