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

    public function create()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return["token"] = csrf_hash();

        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");

        $auth = service("auth");

        if ($auth->login($email, $password) == false) {
            $return["error"] = "Por favor, verifique os erros abaixo e tente novamente.";
            $return["errors_model"] = ["credentials" => "Não encontramos suas credenciais de acesso"];

            return $this->response->setJSON($return);
        }

        $userLogged = $auth->getUserLogged();

        session()->setFlashdata("success", "Olá $userLogged->name, obrigado por acessar nosso sistema sistema");

        if ($userLogged->is_client) {
            $return["redirect"] = "orders/my";
            return $this->response->setJSON($return);
        }

        $return["redirect"] = "home";
        return $this->response->setJSON($return);
    }
}
