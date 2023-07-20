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
    
    protected $validationMessages   = [];
}
