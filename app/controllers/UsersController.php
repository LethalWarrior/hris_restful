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
        try {
            if ($this->modelsManager === null) {
                throw new \Exception('modelsManager is null');
            }

            $query = 'SELECT * FROM App\Models\Users ORDER BY id';

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

            echo json_encode($data);
        } catch (Exception $e) {
            $response = new Response();
            $response->setStatusCode(500);
            $response->setJsonContent(["error" => "It seems that there is an error in the server"]);
            $response->send();
        }
    }
}
