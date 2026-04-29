<?php

namespace App\Models;

use CodeIgniter\Model;

class EtudiantModel extends Model
{
    protected $table            = 'matiere_etudiants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'student_number',
    ];

    protected $useTimestamps = false;

    public function getEtudiantsAvecStats(): array
    {
        return $this->db->table($this->table . ' e')
            ->select('e.id, e.first_name, e.last_name, e.student_number')
            ->select('COUNT(n.id) AS notes_count')
            ->select('AVG(n.score) AS average_score')
            ->join('matiere_niveaux n', 'n.student_id = e.id', 'left')
            ->groupBy('e.id')
            ->orderBy('e.last_name', 'ASC')
            ->orderBy('e.first_name', 'ASC')
            ->get()
            ->getResultArray();
    }
}
