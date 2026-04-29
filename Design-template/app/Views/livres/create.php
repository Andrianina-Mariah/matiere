<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $errors = session('errors') ?? []; ?>

<div class="card">
    <div class="top-actions">
        <h1>Ajouter un livre</h1>
        <a class="btn" href="<?= site_url('/livre') ?>">Retour catalogue</a>
    </div>

    <form method="post" action="<?= site_url('/livre/store') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row">
            <div class="field">
                <label for="titre">Titre</label>
                <input id="titre" name="titre" type="text" value="<?= esc(old('titre')) ?>" required>
                <?php if (isset($errors['titre'])): ?><div class="error"><?= esc($errors['titre']) ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="auteur">Auteur</label>
                <input id="auteur" name="auteur" type="text" value="<?= esc(old('auteur')) ?>" required>
                <?php if (isset($errors['auteur'])): ?><div class="error"><?= esc($errors['auteur']) ?></div><?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label for="ISBN">ISBN</label>
                <input id="ISBN" name="ISBN" type="text" value="<?= esc(old('ISBN')) ?>" required>
                <?php if (isset($errors['ISBN'])): ?><div class="error"><?= esc($errors['ISBN']) ?></div><?php endif; ?>
            </div>

            <div class="field">
                <label for="annee_publication">Annee de publication</label>
                <input id="annee_publication" name="annee_publication" type="number" max="<?= esc((string) $anneeMax) ?>" value="<?= esc(old('annee_publication')) ?>" required>
                <?php if (isset($errors['annee_publication'])): ?><div class="error"><?= esc($errors['annee_publication']) ?></div><?php endif; ?>
            </div>
        </div>

        <div class="field">
            <label for="categorie">Categorie</label>
            <select id="categorie" name="categorie" required>
                <option value="">Choisir</option>
                <?php foreach (($categories ?? []) as $cat): ?>
                    <option value="<?= esc($cat) ?>" <?= old('categorie') === $cat ? 'selected' : '' ?>><?= esc($cat) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label for="resume">Resume</label>
            <textarea id="resume" name="resume" rows="4"><?= esc(old('resume')) ?></textarea>
        </div>

        <div class="field">
            <label for="couverture">Couverture (jpeg/png/webp, max 2 Mo)</label>
            <input id="couverture" name="couverture" type="file" accept="image/jpeg,image/png,image/webp">
        </div>

        <button class="btn btn-primary" type="submit">Enregistrer</button>
    </form>
</div>

<?= $this->endSection() ?>
