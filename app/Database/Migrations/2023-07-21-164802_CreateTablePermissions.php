<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePermissions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 5,
                "unsigmed" => true,
                "auto_increment" => true,
            ],
            "name" => [
                "type" => "VARCHAR",
                "constraint" => "128",
            ],
        ]);

        $this->forge->addKey("id", true);
        $this->forge->addUniqueKey("name");

        $this->forge->createTable("permissions");
    }

    public function down()
    {
        $this->forge->dropTable("permissions");
    }
}
