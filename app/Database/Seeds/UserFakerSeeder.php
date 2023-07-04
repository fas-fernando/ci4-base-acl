<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserFakerSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();

        $faker = \Faker\Factory::create();

        $quantity_users = 50;

        $pushUsers = [];

        for($i = 0; $i < $quantity_users; $i++) {

            array_push($pushUsers, [
                "name" => $faker->unique()->name,
                "email" => $faker->unique()->email,
                "password_hash" => "123456",
                "status" => true,
            ]);

        }

        $userModel->skipValidation(true)
            ->protect(false)
            ->insertBatch($pushUsers);

        echo "$quantity_users usuários criados com sucesso!";
    }
}
