<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupTempSeeder extends Seeder
{
    public function run()
    {
        $groupModel = new \App\Models\GroupModel();

        $groups = [
            [
                "name" => "Administrador",
                "description" => "Grupo com acesso total ao sistema",
                "show" => false,
            ],
            [
                "name" => "Clientes",
                "description" => "Esse grupo é destinado para atribuição de clientes",
                "show" => false,
            ],
            [
                "name" => "Operação",
                "description" => "Esse grupo acessa o sistema para realizar algumas operações",
                "show" => false,
            ],
        ];

        foreach ($groups as $key => $group) {
            $groupModel->insert($group);
        }

        echo "Grupos criados com sucesso";
    }
}
