<?php

namespace App\Middlewares;

use App\Controllers\Exceptions\Http403Exception;
use App\Controllers\Exceptions\HttpException;
use App\Models\Users;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class RoleMiddleware implements MiddlewareInterface
{
    private $roleCode;
    private $URIs;

    public function __construct(string $roleCode, array $URIs)
    {
        $this->roleCode = $roleCode;
        $this->URIs = $URIs;
    }

    public function call(Micro $app)
    {
        try {
            $uri = $app->request->getURI(true);
            if ($this->isURIPrefixinURIs($uri, $this->URIs)) {
                $authHeader = $app->request->getHeaders()["Authorization"];
                $token = explode(" ", $authHeader)[1];
                $jwtUtil = $app->getDI()->get('jwtUtil');

                $claims = $jwtUtil->decodeToken($token);
                if (!$this->isVerified($claims["id"])) {
                    throw new Http403Exception();
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

    private function isURIPrefixinURIs(string $uri)
    {
        $prefixUri = explode("/", $uri)[2];
        foreach ($this->URIs as $URI) {
            if ($prefixUri == explode("/", $URI)[2]) {
                return true;
            }
        }
        return false;
    }

    private function isVerified(string $userId)
    {
        $user = Users::findFirst($userId);
        return $user && $user->getRole()->getRoleCode() == $this->roleCode;
    }
}
