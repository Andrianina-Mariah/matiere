<?php

namespace App\Controllers;

use App\Models\EmpruntModel;
use App\Models\LivreModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Livre extends BaseController
{
    private const PER_PAGE = 10;

    public function index(): string
    {
        $livreModel = new LivreModel();

        $motCle = trim((string) $this->request->getGet('q'));
        $categorie = trim((string) $this->request->getGet('categorie'));

        if ($motCle !== '' || $categorie !== '') {
            $livres = $livreModel->rechercher($motCle, $categorie)->paginate(self::PER_PAGE, 'livres');
        } else {
            $livres = $livreModel->getLivresPagines(self::PER_PAGE, 'livres');
        }

        return view('livres/index', [
            'livres' => $livres,
            'pager' => $livreModel->pager,
            'categories' => $livreModel->getCategories(),
            'q' => $motCle,
            'categorieSelectionnee' => $categorie,
        ]);
    }

    public function show(int $id): string
    {
        $livreModel = new LivreModel();
        $empruntModel = new EmpruntModel();

        $livre = $livreModel->find($id);

        if ($livre === null) {
            throw PageNotFoundException::forPageNotFound('Livre introuvable : ' . $id);
        }

        return view('livres/show', [
            'livre' => $livre,
            'dernierEmprunt' => $empruntModel->dernierEmprunt($id),
        ]);
    }

    public function create(): string
    {
        return view('livres/create', [
            'categories' => ['Roman', 'Science', 'Histoire', 'Informatique', 'Autre'],
            'anneeMax' => (int) date('Y'),
        ]);
    }

    public function store()
    {
        $livreModel = new LivreModel();

        $annee = (int) $this->request->getPost('annee_publication');
        if (! $livreModel->anneePublicationValide($annee)) {
            return redirect()->back()->withInput()->with('error', "L'annee de publication ne peut pas etre dans le futur.");
        }

        $nomFichierCouverture = null;
        $couverture = $this->request->getFile('couverture');

        if ($couverture !== null && $couverture->getName() !== '') {
            if (! $couverture->isValid()) {
                return redirect()->back()->withInput()->with('error', 'Le fichier de couverture est invalide.');
            }

            $reglesUpload = [
                'couverture' => [
                    'label' => 'Couverture',
                    'rules' => 'is_image[couverture]|mime_in[couverture,image/jpg,image/jpeg,image/png,image/webp]|max_size[couverture,2048]',
                ],
            ];

            if (! $this->validate($reglesUpload)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getError('couverture'));
            }

            $uploadPath = FCPATH . 'upload';
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $nomFichierCouverture = $couverture->getRandomName();
            $couverture->move($uploadPath, $nomFichierCouverture);
        }

        $data = [
            'titre' => (string) $this->request->getPost('titre'),
            'auteur' => (string) $this->request->getPost('auteur'),
            'ISBN' => (string) $this->request->getPost('ISBN'),
            'annee_publication' => $annee,
            'categorie' => (string) $this->request->getPost('categorie'),
            'resume' => (string) $this->request->getPost('resume'),
            'nom_fichier_couverture' => $nomFichierCouverture,
            'statut' => 'disponible',
        ];

        if (! $livreModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $livreModel->errors());
        }

        return redirect()->to('/livre')->with('success', 'Livre ajoute avec succes.');
    }

    public function delete(int $id)
    {
        $livreModel = new LivreModel();

        $livre = $livreModel->find($id);
        if ($livre === null) {
            return redirect()->to('/livre')->with('error', 'Livre introuvable.');
        }

        $livreModel->delete($id);

        return redirect()->to('/livre')->with('success', 'Livre supprime avec succes.');
    }
}
