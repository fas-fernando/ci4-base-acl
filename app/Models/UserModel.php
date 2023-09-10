<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $returnType       = 'App\Entities\User';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        "name",
        "email",
        "password",
        "reset_hash",
        "reset_expires_in",
        "avatar",
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "id" => "permit_empty|is_natural_no_zero",
        "name" => "required|min_length[3]|max_length[125]",
        "email" => "required|valid_email|max_length[230]|is_unique[users.email,id,{id}]",
        "password" => "required|min_length[6]",
        "password_confirmation" => "required_with[password]|matches[password]"
    ];
    protected $validationMessages   = [];

    // Callbacks
    protected $beforeInsert   = ["hashPassword"];
    protected $beforeUpdate   = ["hashPassword"];

    protected function hashPassword(array $data)
    {
        if (isset($data["data"]["password"])) {
            $data["data"]["password_hash"] = password_hash($data["data"]["password"], PASSWORD_DEFAULT);
            unset($data["data"]["password"]);
            unset($data["data"]["password_confirmation"]);
        }

        return $data;
    }

    public function getUserByEmail(string $email)
    {
        return $this->where("email", $email)->where("deleted_at", null)->first();
    }

    public function getPermissionsUserLogged(int $user_id)
    {
        $attr = [
            "users.id",
            "users.name AS user_name",
            "groups_users.*",
            "permissions.name AS permission_name",
        ];

        return $this->select($attr)
            ->asArray()
            ->join("groups_users", "groups_users.user_id = users.id")
            ->join("groups_permissions", "groups_permissions.group_id = groups_users.group_id")
            ->join("permissions", "permissions.id = groups_permissions.permission_id")
            ->where("users.id", $user_id)
            ->groupBy("permissions.name")
            ->findAll();
    }
}
