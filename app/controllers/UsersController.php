<?php

namespace App\Controllers;

use Exception;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function initialize()
    {
        $this->modelsManager = $this->getDI()->get('modelsManager');
    }

    public function getUsers()
    {
        $response = new Response();

        try {
            if ($this->modelsManager === null) {
                throw new \Exception('modelsManager is null');
            }

            $query = 'SELECT * FROM App\Models\Users WHERE role_id = 2 ORDER BY id';

            $users = $this->modelsManager->executeQuery($query);

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

            $response->setStatusCode(200);
            $response->setJsonContent($data);
            return $response;
        } catch (Exception $e) {
            $response->setStatusCode(500);
            $response->setJsonContent(["error" => "It seems that there is an error in the server"]);
            return $response;
        }
    }
}
