<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NoteModel;
use App\Models\SujetModel;

class Note extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $noteModel = new NoteModel();

        return view('notes/index', [
            'title' => 'Liste des notes',
            'notes' => $noteModel->getNotesList(),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $etudiantModel = new EtudiantModel();
        $sujetModel = new SujetModel();

        return view('notes/create', [
            'title' => 'Ajouter une note',
            'etudiants' => $etudiantModel->orderBy('last_name', 'ASC')->findAll(),
            'sujets' => $sujetModel->getForForm(),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $noteModel = new NoteModel();

        $studentId = (int) $this->request->getPost('student_id');
        $subjectId = (int) $this->request->getPost('subject_id');
        $score = (float) $this->request->getPost('score');

        if ($studentId <= 0 || $subjectId <= 0) {
            return redirect()->back()->withInput()->with('error', 'Etudiant et matiere obligatoires.');
        }

        if ($score < 0 || $score > 20) {
            return redirect()->back()->withInput()->with('error', 'La note doit etre entre 0 et 20.');
        }

        $noteModel->insert([
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'score' => $score,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/notes')->with('success', 'Note ajoutee avec succes.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $noteModel = new NoteModel();
        $noteModel->delete($id);

        return redirect()->to('/notes')->with('success', 'Note supprimee.');
    }
}
