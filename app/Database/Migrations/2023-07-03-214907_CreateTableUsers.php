<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUsers extends Migration
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
            "email" => [
                "type" => "VARCHAR",
                "constraint" => "240",
            ],
            "password_hash" => [
                "type" => "VARCHAR",
                "constraint" => "240",
            ],
            "reset_hash" => [
                "type" => "VARCHAR",
                "constraint" => "80",
                "null" => true,
                "defaault" => null,
            ],
            "reset_expires_in" => [
                "type" => "DATETIME",
                "null" => true,
                "defaault" => null,
            ],
            "avatar" => [
                "type" => "VARCHAR",
                "constraint" => "240",
                "null" => true,
                "defaault" => null,
            ],
            "status" => [
                "type" => "BOOLEAN",
                "null" => false,
            ],
            "created_at" => [
                "type" => "DATETIME",
                "null" => true,
                "defaault" => null,
            ],
            "updated_at" => [
                "type" => "DATETIME",
                "null" => true,
                "defaault" => null,
            ],
            "deleted_at" => [
                "type" => "DATETIME",
                "null" => true,
                "defaault" => null,
            ],
        ]);

        $this->forge->addKey("id", true);
        $this->forge->addUniqueKey("email");

        $this->forge->createTable("users");
    }

    public function down()
    {
        $this->forge->dropTable("users");
    }
}
