<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function initialize()
    {
        $this->modelsManager = $this->getDI()->get('modelsManager');
    }

    public function getUsers()
    {
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
    }
}
