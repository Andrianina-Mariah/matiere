<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NoteModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Etudiant extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $etudiantModel = new EtudiantModel();

        return view('etudiants/index', [
            'title' => 'Etudiants',
            'etudiants' => $etudiantModel->getEtudiantsAvecStats(),
        ]);
    }

    public function show(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $etudiantModel = new EtudiantModel();
        $noteModel = new NoteModel();

        $etudiant = $etudiantModel->find($id);
        if ($etudiant === null) {
            throw PageNotFoundException::forPageNotFound('Etudiant introuvable : ' . $id);
        }

        $semester = strtoupper((string) $this->request->getGet('sem'));
        if (! in_array($semester, ['S3', 'S4', 'L2'], true)) {
            $semester = 'S3';
        }

        $pathway = strtolower((string) $this->request->getGet('pathway'));
        $allowedPathways = ['dev', 'bddres', 'web'];
        if (! in_array($pathway, $allowedPathways, true)) {
            $pathway = 'dev';
        }

        if ($semester === 'S3') {
            $pathway = 'common';
            $subjects = $noteModel->getStudentSubjectsWithMaxScore($id, 'S3');
        } elseif ($semester === 'S4') {
            $subjects = $noteModel->getStudentSubjectsWithMaxScore($id, 'S4', $pathway);
        } else {
            $subjects = array_merge(
                $noteModel->getStudentSubjectsWithMaxScore($id, 'S3'),
                $noteModel->getStudentSubjectsWithMaxScore($id, 'S4', $pathway)
            );
        }

        $summary = $this->buildSummary($subjects);

        return view('etudiants/show', [
            'title' => 'Releve de notes',
            'etudiant' => $etudiant,
            'subjects' => $subjects,
            'semester' => $semester,
            'pathway' => $pathway,
            'summary' => $summary,
            'allowedPathways' => $allowedPathways,
        ]);
    }

    private function buildSummary(array $subjects): array
    {
        $mandatoryScores = [];
        $optionalScores = [];

        foreach ($subjects as $subject) {
            if ($subject['score'] === null) {
                continue;
            }

            if ((int) $subject['is_optional'] === 1) {
                $optionalScores[] = (float) $subject['score'];
            } else {
                $mandatoryScores[] = (float) $subject['score'];
            }
        }

        $scores = $mandatoryScores;
        if (! empty($optionalScores)) {
            $scores[] = max($optionalScores);
        }

        $average = null;
        if (! empty($scores)) {
            $average = array_sum($scores) / count($scores);
        }

        return [
            'count' => count($scores),
            'average' => $average,
            'mention' => $this->mentionFromScore($average),
        ];
    }

    private function mentionFromScore(?float $score): string
    {
        if ($score === null) {
            return '--';
        }

        if ($score >= 16) {
            return 'TB';
        }

        if ($score >= 14) {
            return 'B';
        }

        if ($score >= 12) {
            return 'AB';
        }

        if ($score >= 10) {
            return 'P';
        }

        return 'Comp.';
    }
}
