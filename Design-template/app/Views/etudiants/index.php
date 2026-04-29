<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h2>Liste des etudiants</h2>
        <p class="muted">Selectionnez un etudiant pour consulter son releve.</p>
    </div>
    <a class="btn btn-primary" href="<?= site_url('/notes/create') ?>">Ajouter une note</a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Etudiant</th>
                <th>Notes saisies</th>
                <th>Moyenne</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($etudiants)): ?>
                <tr>
                    <td colspan="5">Aucun etudiant enregistre.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td class="mono"><?= esc($etudiant['student_number']) ?></td>
                    <td>
                        <div class="student-row">
                            <div class="avatar">
                                <?= esc(strtoupper(substr($etudiant['first_name'], 0, 1) . substr($etudiant['last_name'], 0, 1))) ?>
                            </div>
                            <div>
                                <div class="name">
                                    <?= esc($etudiant['first_name'] . ' ' . $etudiant['last_name']) ?>
                                </div>
                                <div class="muted">ID #<?= esc((string) $etudiant['id']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td><?= esc((string) ($etudiant['notes_count'] ?? 0)) ?></td>
                    <td>
                        <?php if ($etudiant['average_score'] !== null): ?>
                            <?= number_format((float) $etudiant['average_score'], 2, '.', ' ') ?>/20
                        <?php else: ?>
                            --
                        <?php endif; ?>
                    </td>
                    <td class="text-right">
                        <a class="btn btn-secondary btn-sm" href="<?= site_url('/etudiants/' . (int) $etudiant['id']) ?>">Voir le releve</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
