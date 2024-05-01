<?php

return new \Phalcon\Config(
    [
        'database' => [
            'adapter' => 'Postgresql',
            'host' => '',
            'port' => 5432,
            'username' => '',
            'password' => '',
            'dbname' => '',
        ],
        'application' => [
            'controllersDir' => "app/controllers/",
            'modelsDir' => "app/models/",
            'baseUri' => "/",
        ],
        'jwt' => [
            'issuer' => '',
            'expiredAt' => 15, // In minute
            'secretKey' => '',
        ],
    ]
);
