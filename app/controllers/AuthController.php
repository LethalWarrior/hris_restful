<?php

namespace App\Controllers;

use App\Models\Users;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class AuthController extends Controller
{
    public function login()
    {
        $response = new Response();

        $data = $this->request->getJsonRawBody();
        if (!$data) {
            $response->setStatusCode(400);
            $response->setJsonContent(['error' => 'Invalid JSON payload']);
            return $response;
        }

        $username = $data->username ?? '';
        $password = $data->password ?? '';

        $user = Users::findFirst([
            "conditions" => "username = :username:",
            "bind" => ["username" => $username]
        ]);
        if ($user) {
            if ($this->security->checkHash($password, $user->password)) {
                $token = $this->getDI()->get('jwtUtil')->issueToken($user->id, $user->getRole()->getRoleCode());
                $response->setStatusCode(200);
                $response->setJsonContent(["token" => $token]);
                return $response;
            }
        }

        $response->setStatusCode(401);
        $response->setJsonContent(["error" => "Invalid Credentials"]);
        return $response;
    }
}
