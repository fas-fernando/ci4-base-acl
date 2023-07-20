<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;

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

        $users = $this->userModel->select($attr)
            ->orderBy("id", "DESC")
            ->findAll();

        $data = [];

        foreach ($users as $key => $user) {
            $data[] = [
                "avatar" => $user->avatar,
                "name" => anchor("users/show/$user->id", esc($user->name), 'title="Exibir usuário ' . esc($user->name) . '"'),
                "email" => esc($user->email),
                "status" => ($user->status == true ? "<i class='fa fa-unlock text-success'></i>&nbsp;Ativo" : "<i class='fa fa-lock text-warning'></i>&nbsp;Inativo"),
            ];
        }

        $return = [
            "data" => $data,
        ];

        return $this->response->setJSON($return);
    }

    public function create()
    {
        $user = new User();

        $data = [
            "title" => "Criar novo usuário",
            "user" => $user
        ];

        return view("Users/create", $data);
    }

    public function store()
    {
        if(!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return["token"] = csrf_hash();
        $post = $this->request->getPost();

        $user = new User($post);

        // echo "<pre>";
        // print_r($user);
        // echo "</pre>";
        // exit;

        if($this->userModel->protect(false)->save($user)) {
            $btnNewUser = anchor("users/create", "Novo usuário", ["class" => "btn btn-warning mt-2"]);
            session()->setFlashdata("success", "Dados salvo com sucesso. <br> $btnNewUser");

            $return["id"] = $this->userModel->getInsertID();

            return $this->response->setJSON($return);
        }

        $return["error"] = "Por favor, verifique os erros abaixo e tente novamente.";
        $return["errors_model"] = $this->userModel->errors();
        
        return $this->response->setJSON($return);
    }

    public function show(int $id = null)
    {
        $user = $this->searchUserOr404($id);

        $data = [
            "title" => "Detalhes do usuário " . esc($user->name),
            "user" => $user,
        ];

        return view("Users/show", $data);
    }

    public function edit(int $id = null)
    {
        $user = $this->searchUserOr404($id);

        $data = [
            "title" => "Editando o usuário " . esc($user->name),
            "user" => $user,
        ];

        return view("Users/edit", $data);
    }

    public function update()
    {
        if(!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return["token"] = csrf_hash();
        $post = $this->request->getPost();

        $user = $this->searchUserOr404($post["id"]);
        
        if(empty($post["password"])) {
            unset($post["password"]);
            unset($post["password_confirmation"]);
        }

        $user->fill($post);

        if($user->hasChanged() == false) {
            $return["info"] = "Não há dados para atualizar.";
            return $this->response->setJSON($return);
        }

        if($this->userModel->protect(false)->save($user)) {
            session()->setFlashdata("success", "Dados salvo com sucesso.");

            return $this->response->setJSON($return);
        }

        $return["error"] = "Por favor, verifique os erros abaixo e tente novamente.";
        $return["errors_model"] = $this->userModel->errors();
        
        return $this->response->setJSON($return);
    }

    public function editAvatar(int $id = null)
    {
        $user = $this->searchUserOr404($id);

        $data = [
            "title" => "Alterando a imagem do usuário " . esc($user->name),
            "user" => $user,
        ];

        return view("Users/edit_avatar", $data);
    }

    public function upload()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return["token"] = csrf_hash();

        $validation = service("validation");

        $rules = [
            'avatar' => 'uploaded[avatar]|max_size[avatar,1024]|ext_in[avatar,png,jpg,jpeg]',
        ];

        $feedback = [
            "avatar" => [
                "uploaded" => "Por favor escolha uma imagem",
                "max_size" => "A imagem não pode ser maior de 1024 MB",
                "ext_in" => "Por favor escolha imagens jpg, jpeg ou png",
            ],
        ];

        $validation->setRules($rules, $feedback);

        if (!$validation->withRequest($this->request)->run()) {
            $return["error"] = "Por favor, verifique os erros abaixo e tente novamente.";
            $return["errors_model"] = $validation->getErrors();

            return $this->response->setJSON($return);
        }

        $post = $this->request->getPost();
        $user = $this->searchUserOr404($post["id"]);

        $avatar = $this->request->getFile('avatar');

        list($width, $height) = getimagesize($avatar->getPathName());

        if($width < "300" || $height < "300") {
            $return["error"] = "Por favor, verifique os erros abaixo e tente novamente.";
            $return["errors_model"] = ["dimension" => "A imagem não pode ser menor que 300 x 300 pixels"];

            return $this->response->setJSON($return);
        }

        $imagePath = $avatar->store("users");
        $imagePath = WRITEPATH . "uploads/$imagePath";

        $this->manipulateImage($imagePath, $user->id);

        $oldImage = $user->avatar;

        $user->avatar = $avatar->getName();

        $this->userModel->save($user);

        if($oldImage != null) {
            $this->removeImageFileSystem($oldImage);
        }

        session()->setFlashdata("success", "Imagem atualizada com sucesso.");

        return $this->response->setJSON($return);
    }

    public function showAvatar(string $image = null)
    {
        if($image != null) {
            $this->showFile("users", $image);
        }
    }

    private function searchUserOr404(int $id = null)
    {
        $user = $this->userModel->withDeleted(true)->find($id);

        if(!$id || !$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuário $id");
        }

        return $user;
    }

    private function manipulateImage(string $imagePath, int $user_id)
    {
        service('image')
            ->withFile($imagePath)
            ->fit(300, 300, 'center')
            ->save($imagePath);

        $currentYear = date("Y");

        \Config\Services::image('imagick')
            ->withFile($imagePath)
            ->text("ESTBANK $currentYear - User: $user_id", [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => false,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 20,
            ])
            ->save($imagePath);
    }

    private function removeImageFileSystem(string $image)
    {
        $imagePath = WRITEPATH . "uploads/users/$image";

        if(is_file($imagePath)) {
            unlink($imagePath);
        }
    }
}
