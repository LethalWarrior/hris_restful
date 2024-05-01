<?php

use App\Utils\JWTUtil;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Postgresql;
use Phalcon\Mvc\Model\Manager;

$config = require(__DIR__ . '/../config/config.php');

$di = new FactoryDefault();

$di->setShared('config', $config);

$di->set(
    'modelsManager',
    function () {
        return new Manager();
    }
);

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

$di->set(
    'jwtUtil',
    function () use ($config) {
        return new JWTUtil(
            [
                "secretKey" => $config->jwt->secretKey,
                "issuer" => $config->jwt->issuer,
                "expiredAt" => $config->jwt->expiredAt,
            ]
        );
    }
);

return $di;
