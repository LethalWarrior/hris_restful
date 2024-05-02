<?php

use Phalcon\Mvc\Micro\Collection;
use App\Controllers\UsersController;

$userRoutes = new Collection();
$userRoutes->setHandler(new UsersController());
$userRoutes->setPrefix('/api/users');
$userRoutes->get('/', 'getUsers');
$userRoutes->get('/{userId}', 'getUser');

return $userRoutes;
