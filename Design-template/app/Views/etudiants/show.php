<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
function mentionFromScore($score): string {
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
$baseUrl = site_url('/etudiants/' . (int) $etudiant['id']);
$semesterLabel = $semester === 'S3' ? 'Semestre 3' : ($semester === 'S4' ? 'Semestre 4' : 'Releve annuel');
?>

<div class="page-header">
    <div>
        <h2>Releve de notes</h2>
        <p class="muted">
            <?= esc($etudiant['first_name'] . ' ' . $etudiant['last_name']) ?>
            · Matricule <?= esc($etudiant['student_number']) ?>
        </p>
    </div>
    <a class="btn btn-secondary" href="<?= site_url('/etudiants') ?>">Retour liste</a>
</div>

<div class="tabs">
    <a class="tab <?= $semester === 'S3' ? 'active' : '' ?>" href="<?= $baseUrl ?>?sem=S3">Semestre 3</a>
    <a class="tab <?= $semester === 'S4' ? 'active' : '' ?>" href="<?= $baseUrl ?>?sem=S4&pathway=<?= esc($pathway) ?>">Semestre 4</a>
    <a class="tab <?= $semester === 'L2' ? 'active' : '' ?>" href="<?= $baseUrl ?>?sem=L2&pathway=<?= esc($pathway) ?>">L2 (S3 + S4)</a>
</div>

<?php if (in_array($semester, ['S4', 'L2'], true)): ?>
    <div class="pill-row">
        <?php foreach ($allowedPathways as $option): ?>
            <a class="pill <?= $pathway === $option ? 'active' : '' ?>" href="<?= $baseUrl ?>?sem=<?= esc($semester) ?>&pathway=<?= esc($option) ?>">
                Option <?= esc($option) ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="paper">
    <div class="paper-head">
        <div>
            <div class="paper-title"><?= esc($semesterLabel) ?></div>
            <div class="muted">Parcours: <?= esc($pathway === 'common' ? 'commun' : $pathway) ?></div>
        </div>
        <div class="paper-meta">
            <div>Notes max par matiere</div>
            <div class="muted">Optionnels: meilleure note retenue</div>
        </div>
    </div>

    <table class="data-table doc-table">
        <thead>
            <tr>
                <th>UE</th>
                <th>Intitule</th>
                <th>Credits</th>
                <th>Note/20</th>
                <th>Resultat</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($subjects)): ?>
                <tr><td colspan="5">Aucune matiere trouvee.</td></tr>
            <?php endif; ?>
            <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td class="mono">UE<?= esc((string) $subject['subject_id']) ?></td>
                    <td>
                        <?= esc($subject['name']) ?>
                        <?php if ((int) $subject['is_optional'] === 1): ?>
                            <span class="badge badge-optional">Option</span>
                        <?php endif; ?>
                    </td>
                    <td class="muted">--</td>
                    <td><?= $subject['score'] === null ? '--' : number_format((float) $subject['score'], 2, '.', ' ') ?></td>
                    <td><?= esc(mentionFromScore($subject['score'] === null ? null : (float) $subject['score'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="summary">
        <div>
            <div class="summary-label">Matieres prises en compte</div>
            <div class="summary-value"><?= esc((string) $summary['count']) ?></div>
        </div>
        <div>
            <div class="summary-label">Moyenne generale</div>
            <div class="summary-value">
                <?= $summary['average'] === null ? '--' : number_format((float) $summary['average'], 2, '.', ' ') ?>
            </div>
        </div>
        <div>
            <div class="summary-label">Mention</div>
            <div class="summary-value"><?= esc($summary['mention']) ?></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
