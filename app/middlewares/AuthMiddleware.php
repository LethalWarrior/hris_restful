<?php

namespace App\Middlewares;

use Exception;
use Firebase\JWT\ExpiredException;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

use function PHPSTORM_META\type;

class AuthMiddleware implements MiddlewareInterface
{
    private $URIWhiteList = [
        '/api/login'
    ];

    public function call(Micro $app)
    {
        try {
            $uri = $app->request->getURI(true);
            if (!in_array($uri, $this->URIWhiteList)) {
                $authHeader = $app->request->getHeaders()["Authorization"];
                if ($authHeader && strlen($authHeader) > 0) {
                    $token = explode(" ", $authHeader)[1];
                    $jwtHandler = $app->getDI()->get('jwtHandler');
                    $jwtHandler->decodeToken($token);
                } else {
                    $this->unauthorized($app);
                    return false;
                }
            }
            return true;
        } catch (ExpiredException $e) {
            $this->unauthorized($app);
            return false;
        }
    }

    private function unauthorized(Micro $app)
    {
        $app->response->setStatusCode(401);
        $app->response->setJsonContent(["error" => "Unauthorized"]);
        $app->response->send();
        $app->stop();
    }
}
