<?php

namespace App\Controllers;

use App\Models\EmpruntModel;
use App\Models\LivreModel;

class Emprunt extends BaseController
{
    public function pret(int $livreId)
    {
        $livreModel = new LivreModel();
        $empruntModel = new EmpruntModel();

        $livre = $livreModel->find($livreId);
        if ($livre === null) {
            return redirect()->to('/livre')->with('error', 'Livre introuvable.');
        }

        if (($livre['statut'] ?? '') !== 'disponible') {
            return redirect()->to('/livre')->with('error', 'Ce livre est deja prete.');
        }

        $nomEmprunteur = trim((string) $this->request->getPost('nom_emprunteur'));
        if ($nomEmprunteur === '') {
            return redirect()->to('/livre')->with('error', "Le nom de l'emprunteur est obligatoire.");
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $empruntModel->insert([
            'livre_id' => $livreId,
            'nom_emprunteur' => $nomEmprunteur,
            'date_emprunt' => date('Y-m-d'),
            'date_retour' => null,
        ]);

        $livreModel->update($livreId, ['statut' => 'prete']);

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->to('/livre')->with('error', "Erreur lors de l'enregistrement de l'emprunt.");
        }

        return redirect()->to('/livre')->with('success', 'Livre prete avec succes.');
    }

    public function retour(int $livreId)
    {
        $livreModel = new LivreModel();
        $empruntModel = new EmpruntModel();

        $livre = $livreModel->find($livreId);
        if ($livre === null) {
            return redirect()->to('/livre')->with('error', 'Livre introuvable.');
        }

        $empruntActif = $empruntModel->empruntActif($livreId);
        if ($empruntActif === null) {
            return redirect()->to('/livre')->with('error', 'Aucun emprunt actif trouve pour ce livre.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $empruntModel->update($empruntActif['identifiant'], [
            'date_retour' => date('Y-m-d'),
        ]);

        $livreModel->update($livreId, ['statut' => 'disponible']);

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->to('/livre')->with('error', 'Erreur lors du retour du livre.');
        }

        return redirect()->to('/livre')->with('success', 'Livre retourne avec succes.');
    }
}
