<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table            = 'groups';
    protected $returnType       = 'App\Entities\Group';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        "name",
        "description",
        "show",
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "id" => "permit_empty|is_natural_no_zero",
        "name" => "required|min_length[3]|max_length[125]|is_unique[groups.name,id,{id}]",
        "description" => "required|max_length[240]",
    ];
    
    protected $validationMessages   = [
        "name" => [
            "required" => "O campo <strong class='text-white'>nome</strong> é de preenchimento obrigatório.",
            "min_length" => "O campo <strong class='text-white'>nome</strong> deve conter no minimo 3 caracteres.",
            "max_length" => "O campo <strong class='text-white'>nome</strong> não pode passar de 125 caracteres.",
            "is_unique" => "Esse <strong class='text-white'>nome</strong> já existe em nossa base de dados.",
        ],
        "description" => [
            "required" => "O campo <strong class='text-white'>descrição</strong> é de preenchimento obrigatório.",
            "max_length" => "O campo <strong class='text-white'>descrição</strong> não pode passar de 240 caracteres.",
        ],
    ];
}
