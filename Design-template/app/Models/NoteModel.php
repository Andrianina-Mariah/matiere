<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table            = 'matiere_niveaux';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'student_id',
        'subject_id',
        'score',
        'created_at',
    ];

    protected $useTimestamps = false;

    public function getNotesList(): array
    {
        return $this->db->table($this->table . ' n')
            ->select('n.id, n.score, n.created_at')
            ->select('e.id AS student_id, e.first_name, e.last_name, e.student_number')
            ->select('s.id AS subject_id, s.name AS subject_name, s.semester, s.pathway, s.is_optional')
            ->join('matiere_etudiants e', 'e.id = n.student_id', 'left')
            ->join('matiere_sujets s', 's.id = n.subject_id', 'left')
            ->orderBy('n.created_at', 'DESC')
            ->orderBy('n.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getStudentSubjectsWithMaxScore(int $studentId, string $semester, ?string $pathway = null): array
    {
        $builder = $this->db->table('matiere_sujets s')
            ->select('s.id AS subject_id, s.name, s.semester, s.pathway, s.is_optional')
            ->select('MAX(n.score) AS score')
            ->join(
                $this->table . ' n',
                'n.subject_id = s.id AND n.student_id = ' . (int) $studentId,
                'left'
            )
            ->where('s.semester', $semester)
            ->groupBy('s.id')
            ->orderBy('s.name', 'ASC');

        if ($pathway !== null && $pathway !== '') {
            $builder->groupStart()
                ->where('s.pathway', 'common')
                ->orWhere('s.pathway', $pathway)
                ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }
}
