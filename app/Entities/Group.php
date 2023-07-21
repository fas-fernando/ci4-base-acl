<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Group extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];

    public function showSituation()
    {
        if($this->deleted_at != null) {
            $icon = "<i class='fa fa-undo'></i>&nbsp;Restaurar";
    
            $btnRestore = anchor("groups/restore/$this->id", $icon, ["class" => "btn btn-outline-success btn-sm"]);
    
            return $btnRestore;
        }

        if($this->show == true) {
            return "<i class='fa fa-eye text-success'></i>&nbsp;Exibindo";
        }

        if($this->show == false) {
            return "<i class='fa fa-eye-slash text-danger'></i>&nbsp;Não exibindo";
        }
    }
}
