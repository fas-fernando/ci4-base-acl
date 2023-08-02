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

        // dd($auth->isLogged());
        // dd($auth->isClient());


        // dd($auth->login("darius70@yahoo.com", "123456"));
        // dd($auth->getUserLogged());
    }
}
