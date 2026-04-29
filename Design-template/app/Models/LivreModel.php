<?php

namespace App\Models;

use CodeIgniter\Model;

class LivreModel extends Model
{
    protected $table            = 'livres';
    protected $primaryKey       = 'identifiant';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'titre',
        'auteur',
        'ISBN',
        'annee_publication',
        'categorie',
        'resume',
        'nom_fichier_couverture',
        'statut',
    ];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'titre' => 'required|min_length[3]',
        'auteur' => 'required',
        'ISBN' => 'required|is_unique[livres.ISBN,identifiant,{identifiant}]',
        'annee_publication' => 'required|integer',
    ];

    protected $validationMessages = [
        'titre' => [
            'required' => 'Le titre est obligatoire.',
            'min_length' => 'Le titre doit contenir au moins 3 caracteres.',
        ],
        'auteur' => [
            'required' => "L'auteur est obligatoire.",
        ],
        'ISBN' => [
            'required' => "L'ISBN est obligatoire.",
            'is_unique' => "Cet ISBN existe deja dans la base.",
        ],
        'annee_publication' => [
            'required' => "L'annee de publication est obligatoire.",
            'integer' => "L'annee de publication doit etre un nombre entier.",
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function anneePublicationValide(int $annee): bool
    {
        return $annee <= (int) date('Y');
    }

    /**
     * Recherche par mot-cle sur le titre + categorie optionnelle.
     */
    public function rechercher(?string $motCle = null, ?string $categorie = null): self
    {
        if ($motCle !== null && $motCle !== '') {
            $this->like('titre', $motCle);
        }

        if ($categorie !== null && $categorie !== '') {
            $this->where('categorie', $categorie);
        }

        return $this->orderBy('titre', 'ASC');
    }

    public function getLivresPagines(int $perPage = 10, string $group = 'livres'): array
    {
        return $this->orderBy('created_at', 'DESC')->paginate($perPage, $group);
    }

    public function getCategories(): array
    {
        return $this->select('categorie')
            ->distinct()
            ->where('categorie IS NOT NULL', null, false)
            ->where('categorie !=', '')
            ->orderBy('categorie', 'ASC')
            ->findColumn('categorie') ?? [];
    }
}
