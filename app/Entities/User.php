<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];

    public function showSituation()
    {
        if($this->deleted_at != null) {
            $icon = "<span class='text-white'></span> <i class='fa fa-undo'></i>&nbsp;Restaurar";
    
            $btnRestore = anchor("users/restore/$this->id", $icon, ["class" => "btn btn-outline-success btn-sm"]);
    
            return $btnRestore;
        }

        if($this->status == true) {
            return "<i class='fa fa-unlock text-success'></i>&nbsp;Ativo";
        }

        if($this->status == false) {
            return "<i class='fa fa-lock text-warning'></i>&nbsp;Inativo";
        }
    }
}
