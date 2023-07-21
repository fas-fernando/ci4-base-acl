<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissionModel = new \App\Models\PermissionModel();

        $permissions = [
            ["name" => "list-users"],
            ["name" => "create-users"],
            ["name" => "edit-users"],
            ["name" => "delete-users"],
        ];

        foreach ($permissions as $key => $permission) {
            $permissionModel->protect(false)->insert($permission);
        }

        echo "Permissões criadas com sucesso";
    }
}
