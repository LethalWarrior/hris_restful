<?php

namespace App\Middlewares;

use App\Controllers\Exceptions\Http401Exception;
use App\Controllers\Exceptions\HttpException;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    private $excludeURIs;

    public function __construct(array $excludeURIs)
    {
        $this->excludeURIs = $excludeURIs;
    }

    public function call(Micro $app)
    {
        try {
            $uri = $app->request->getURI(true);
            if (!in_array($uri, $this->excludeURIs)) {
                $authHeader = $app->request->getHeaders()["Authorization"];
                if ($authHeader && strlen($authHeader) > 0) {
                    $token = explode(" ", $authHeader)[1];
                    $jwtUtil = $app->getDI()->get('jwtUtil');
                    $jwtUtil->decodeToken($token);
                } else {
                    throw new Http401Exception();
                }
            }
            return true;
        } catch (HttpException $e) {
            $app->response->setStatusCode($e->getStatusCode());
            $app->response->setJsonContent(["error" => $e->getMessage()]);
            $app->response->send();
            $app->stop();
            return false;
        }
    }
}
