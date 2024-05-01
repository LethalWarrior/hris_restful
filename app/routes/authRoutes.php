<?php

use App\Controllers\AuthController;
use Phalcon\Mvc\Micro\Collection;

$authRoutes = new Collection();
$authRoutes->setHandler(new AuthController());
$authRoutes->setPrefix('/api');
$authRoutes->post('/login', 'login');

return $authRoutes;
