<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpruntModel extends Model
{
    protected $table            = 'emprunts';
    protected $primaryKey       = 'identifiant';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'livre_id',
        'nom_emprunteur',
        'date_emprunt',
        'date_retour',
    ];

    protected $useTimestamps = false;

    public function dernierEmprunt(int $livreId): ?array
    {
        return $this->where('livre_id', $livreId)
            ->orderBy('date_emprunt', 'DESC')
            ->orderBy('identifiant', 'DESC')
            ->first();
    }

    public function empruntActif(int $livreId): ?array
    {
        return $this->where('livre_id', $livreId)
            ->where('date_retour', null)
            ->orderBy('date_emprunt', 'DESC')
            ->orderBy('identifiant', 'DESC')
            ->first();
    }
}
