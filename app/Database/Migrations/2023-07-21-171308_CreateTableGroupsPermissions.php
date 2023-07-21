<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableGroupsPermissions extends Migration
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
            "group_id" => [
                "type" => "INT",
                "constraint" => 5,
                "unsigmed" => true,
            ],
            "permission_id" => [
                "type" => "INT",
                "constraint" => 5,
                "unsigmed" => true,
            ],
        ]);

        $this->forge->addKey("id", true);
        $this->forge->addForeignKey("group_id", "groups", "id", "CASCADE", "CASCADE");
        $this->forge->addForeignKey("permission_id", "permissions", "id", "CASCADE", "CASCADE");

        $this->forge->createTable("groups_permissions");
    }

    public function down()
    {
        $this->forge->dropTable("groups_permissions");
    }
}
