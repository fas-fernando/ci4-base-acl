<?php

namespace App\Controllers;

use App\Libraries\Authentication;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "Home",
        ];

        return view('Home/index', $data);
    }

    public function login()
    {
        $auth = new Authentication();

        // $auth->logout();
        $auth->login("fas.alves.souza@gmail.com", "123456");
        // dd($auth->getUserLogged());

        dd($auth->isLogged());
        // dd($auth->isClient());


        // dd($auth->getUserLogged());
    }
}
