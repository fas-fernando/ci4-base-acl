<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Group;

class Groups extends BaseController
{
    private $groupModel;

    public function __construct()
    {
        $this->groupModel = new \App\Models\groupModel();
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
                "show" => ($group->show == true ? "<i class='fa fa-eye text-success'></i>" : "<i class='fa fa-eye-slash text-danger'></i>"),
            ];
        }

        $return = [
            "data" => $data,
        ];

        return $this->response->setJSON($return);
    }
}
