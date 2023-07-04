<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            "title" => "Lista de usuários",
        ];

        return view("Users/index", $data);
    }

    public function getUsers()
    {
        if(!$this->request->isAJAX()) {

            return redirect()->back();

        }

        $attr = ["id", "name", "email", "status", "avatar"];

        $users = $this->userModel->select($attr)->findAll();

        $data = [];

        foreach ($users as $key => $user) {
            $data[] = [
                "avatar" => $user->avatar,
                "name" => esc($user->name),
                "email" => esc($user->email),
                "status" => ($user->status == true ? "<i class='fa fa-unlock text-success'></i>&nbsp;Ativo" : "<i class='fa fa-lock text-warning'></i>&nbsp;Inativo"),
            ];
        }

        $return = [
            "data" => $data,
        ];

        return $this->response->setJSON($return);
    }
}
