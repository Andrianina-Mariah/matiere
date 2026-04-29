<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h2>Liste des notes</h2>
        <p class="muted">Toutes les saisies avec l'etudiant et la matiere (left join).</p>
    </div>
    <a class="btn btn-primary" href="<?= site_url('/notes/create') ?>">Ajouter une note</a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Etudiant</th>
                <th>Matiere</th>
                <th>Semestre</th>
                <th>Parcours</th>
                <th>Note</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($notes)): ?>
                <tr><td colspan="7">Aucune note enregistree.</td></tr>
            <?php endif; ?>
            <?php foreach ($notes as $note): ?>
                <tr>
                    <td class="mono"><?= esc((string) ($note['created_at'] ?? '')) ?></td>
                    <td>
                        <?= esc(($note['first_name'] ?? '--') . ' ' . ($note['last_name'] ?? '')) ?>
                        <div class="muted"><?= esc($note['student_number'] ?? '') ?></div>
                    </td>
                    <td><?= esc($note['subject_name'] ?? '--') ?></td>
                    <td><?= esc($note['semester'] ?? '--') ?></td>
                    <td><?= esc($note['pathway'] ?? '--') ?></td>
                    <td>
                        <?= $note['score'] === null ? '--' : esc(number_format((float) $note['score'], 2, '.', ' ')) ?>
                    </td>
                    <td class="text-right">
                        <form method="post" action="<?= site_url('/notes/delete/' . (int) $note['id']) ?>" onsubmit="return confirm('Supprimer cette note ?');">
                            <?= csrf_field() ?>
                            <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
