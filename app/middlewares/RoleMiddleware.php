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
    private $actions;

    public function __construct(string $roleCode, array $actions)
    {
        $this->roleCode = $roleCode;
        $this->actions = $actions;
    }

    public function call(Micro $app)
    {
        try {
            $uri = $app->request->getURI(true);
            $method = $app->request->getMethod();
            if ($this->isActionInActions($method, $uri)) {
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

    private function isActionInActions(string $method, string $uri)
    {
        foreach ($this->actions as $action) {
            $actionMethod = explode(":", $action)[0];
            $actionUri = explode(":", $action)[1];
            if ($method == $actionMethod && $uri == $actionUri) {
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
