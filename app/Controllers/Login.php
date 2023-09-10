<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function new()
    {
        $data = [
            "title" => "Realize o login"
        ];

        return view("Login/new", $data);
    }
}
