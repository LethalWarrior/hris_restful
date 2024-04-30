<?php

// Load configs
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Postgresql;

$config = require(__DIR__ . '/../config/config.php');

// Autoload
require __DIR__ . '/../config/loader.php';

// Initialize DI Container
$di = new FactoryDefault();

$di->setShared('config', $config);

// Setup database service
$di->set(
    'db',
    function () use ($config) {
        return new Postgresql(
            [
                "host"     => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname"   => $config->database->dbname,
            ]
        );
    }
);



// Initialize App
$app = new Micro();
$app->setDI($di);


$app->get(
    '/api/users',
    function () use ($app) {
        $query = 'SELECT * FROM App\Models\Users ORDER BY id';

        $users = $app->modelsManager->executeQuery($query);

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'fullname' => $user->fullname,
                'username' => $user->username,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
        }

        echo json_encode($data);
    }
);

$app->handle();
