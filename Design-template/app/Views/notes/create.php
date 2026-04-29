<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h2>Ajouter une note</h2>
        <p class="muted">Plusieurs notes peuvent etre saisies pour une meme matiere.</p>
    </div>
    <a class="btn btn-secondary" href="<?= site_url('/notes') ?>">Voir les notes</a>
</div>

<div class="card">
    <form method="post" action="<?= site_url('/notes/store') ?>">
        <?= csrf_field() ?>

        <div class="form-grid">
            <div>
                <label for="student_id">Etudiant</label>
                <select id="student_id" name="student_id" required>
                    <option value="">Selectionner</option>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <option value="<?= esc((string) $etudiant['id']) ?>" <?= old('student_id') == $etudiant['id'] ? 'selected' : '' ?>>
                            <?= esc($etudiant['first_name'] . ' ' . $etudiant['last_name'] . ' - ' . $etudiant['student_number']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="subject_id">Matiere</label>
                <select id="subject_id" name="subject_id" required>
                    <option value="">Selectionner</option>
                    <?php foreach ($sujets as $sujet): ?>
                        <option value="<?= esc((string) $sujet['id']) ?>" <?= old('subject_id') == $sujet['id'] ? 'selected' : '' ?>>
                            <?= esc($sujet['semester'] . ' - ' . $sujet['name'] . ' (' . $sujet['pathway'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-grid">
            <div>
                <label for="score">Note /20</label>
                <input id="score" name="score" type="number" step="0.01" min="0" max="20" value="<?= esc(old('score') ?? '10') ?>" required>
            </div>
            <div class="note-hint">
                <div class="muted">Regles</div>
                <ul>
                    <li>La note maximale est retenue par matiere.</li>
                    <li>Pour les options, seule la meilleure note est prise.</li>
                </ul>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Enregistrer</button>
    </form>
</div>

<?= $this->endSection() ?>
