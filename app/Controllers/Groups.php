<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Group;

class Groups extends BaseController
{
    private $groupModel;
    private $groupPermissionModel;
    private $permissionModel;

    public function __construct()
    {
        $this->groupModel = new \App\Models\groupModel();
        $this->groupPermissionModel = new \App\Models\GroupPermissionModel();
        $this->permissionModel = new \App\Models\PermissionModel();
    }

    public function index()
    {
        $data = [
            "title" => "Lista dos grupos",
        ];

        return view("Groups/index", $data);
    }

    public function getGroups()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $attr = ["id", "name", "description", "show", "deleted_at"];

        $groups = $this->groupModel->select($attr)
            ->withDeleted(true)
            ->orderBy("id", "DESC")
            ->findAll();

        $data = [];

        foreach ($groups as $key => $group) {

            $data[] = [
                "name" => anchor("groups/show/$group->id", esc($group->name), 'title="Exibir grupo ' . esc($group->name) . '"'),
                "description" => esc($group->description),
                "show" => $group->showSituation(),
            ];
        }

        $return = [
            "data" => $data,
        ];

        return $this->response->setJSON($return);
    }

    public function show(int $id = null)
    {
        $group = $this->searchGroupOr404($id);

        $data = [
            "title" => "Detalhes do grupo " . esc($group->name),
            "group" => $group,
        ];

        return view("Groups/show", $data);
    }

    public function create()
    {
        $group = new Group();

        $data = [
            "title" => "Criando o grupo ",
            "group" => $group,
        ];

        return view("Groups/create", $data);
    }

    public function store()
    {
        if(!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return["token"] = csrf_hash();
        $post = $this->request->getPost();

        $group = new Group($post);

        if($this->groupModel->save($group)) {
            $btnNewUser = anchor("groups/create", "Novo grupo", ["class" => "btn btn-warning mt-2"]);
            session()->setFlashdata("success", "Dados salvo com sucesso. <br> $btnNewUser");

            $return["id"] = $this->groupModel->getInsertID();

            return $this->response->setJSON($return);
        }

        $return["error"] = "Por favor, verifique os erros abaixo e tente novamente.";
        $return["errors_model"] = $this->groupModel->errors();
        
        return $this->response->setJSON($return);
    }

    public function edit(int $id = null)
    {
        $group = $this->searchGroupOr404($id);

        if($group->id < 3) {
            return redirect()->back()->with("attention", "O grupo <strong>" . esc($group->name) . "</strong> não pode ser editado.");
        }

        $data = [
            "title" => "Editando o grupo " . esc($group->name),
            "group" => $group,
        ];

        return view("Groups/edit", $data);
    }

    public function update()
    {
        if(!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return["token"] = csrf_hash();
        $post = $this->request->getPost();

        $group = $this->searchGroupOr404($post["id"]);

        $groupName = esc($group->name);

        // $group->id = 3; // DEBUG

        if($group->id < 3) {
            $return["error"] = "Por favor, verifique os erros abaixo e tente novamente.";
            $return["errors_model"] = ["group" => "O grupo <strong>$groupName</strong> não pode ser atualizado."];

            return $this->response->setJSON($return);
        }

        $group->fill($post);

        if($group->hasChanged() == false) {
            $return["info"] = "Não há dados para atualizar.";
            return $this->response->setJSON($return);
        }

        if($this->groupModel->protect(false)->save($group)) {
            session()->setFlashdata("success", "Dados salvo com sucesso.");

            return $this->response->setJSON($return);
        }

        $return["error"] = "Por favor, verifique os erros abaixo e tente novamente.";
        $return["errors_model"] = $this->groupModel->errors();
        
        return $this->response->setJSON($return);
    }

    public function delete(int $id = null)
    {
        $group = $this->searchGroupOr404($id);

        if($group->id < 3) {
            return redirect()->back()->with("attention", "O grupo <strong>" . esc($group->name) . "</strong> não pode ser excluído.");
        }

        if($group->deleted_at != null) {
            return redirect()->back()->with("info", "Esse grupo já encontra-se excluído");
        }

        if($this->request->getMethod() === "post") {
            $this->groupModel->delete($group->id);

            $group->show = false;

            $this->groupModel->save($group);

            return redirect()->to(site_url("groups"))->with("success", "Grupo " . $group->name . " excluído com sucesso");
        }

        $data = [
            "title" => "Excluir o grupo " . esc($group->name),
            "group" => $group,
        ];

        return view("Groups/delete", $data);
    }

    public function restore(int $id = null)
    {
        $group = $this->searchGroupOr404($id);

        if($group->deleted_at == null) {
            return redirect()->back()->with("info", "Apenas grupos excluídos podem ser restaurado");
        }
        
        $group->deleted_at = null;
        
        $this->groupModel->protect(false)->save($group);

        return redirect()->back()->with("success", "Grupo " . esc($group->name) . " restaurado com sucesso");
    }

    public function permissions(int $id = null)
    {
        $group = $this->searchGroupOr404($id);

        if($group->id < 3) {
            return redirect()->back()->with("info", "Não é necessário atribuir ou remover permissões de acesso para o grupo <strong>" . esc($group->name) . "</strong>");
        }

        if($group->id > 2) {
            $group->permissions = $this->groupPermissionModel->getPermissionsGroup($group->id, 10);
            $group->pager = $this->groupPermissionModel->pager;
        }

        $data = [
            "title" => "Gerenciando as permissões do grupo " . esc($group->name),
            "group" => $group,
        ];

        if(!empty($group->permissions)) {
            $existingPermission = array_column($group->permissions, "permission_id");

            $data["availablePermissions"] = $this->permissionModel->whereNotIn("id", $existingPermission)->findAll();
        } else {
            $data["availablePermissions"] = $this->permissionModel->findAll();
        }

        return view("Groups/permissions", $data);
    }

    private function searchGroupOr404(int $id = null)
    {
        $group = $this->groupModel->withDeleted(true)->find($id);

        if(!$id || !$group) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o grupo $id");
        }

        return $group;
    }
}
