<?php

namespace App\Models;

use CodeIgniter\Model;

class SujetModel extends Model
{
    protected $table            = 'matiere_sujets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'name',
        'semester',
        'pathway',
        'is_optional',
    ];

    protected $useTimestamps = false;

    public function getForForm(): array
    {
        return $this->orderBy('semester', 'ASC')
            ->orderBy('pathway', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
    }
}
