<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="top-actions">
        <h1>Fiche livre</h1>
        <a class="btn" href="<?= site_url('/livre') ?>">Retour catalogue</a>
    </div>

    <p><strong>Titre:</strong> <?= esc($livre['titre']) ?></p>
    <p><strong>Auteur:</strong> <?= esc($livre['auteur']) ?></p>
    <p><strong>ISBN:</strong> <?= esc($livre['ISBN']) ?></p>
    <p><strong>Annee:</strong> <?= esc((string) $livre['annee_publication']) ?></p>
    <p><strong>Categorie:</strong> <?= esc($livre['categorie']) ?></p>
    <p><strong>Resume:</strong> <?= esc($livre['resume'] ?? '') ?></p>
    <p><strong>Statut:</strong> <?= esc($livre['statut']) ?></p>

    <?php if (! empty($livre['nom_fichier_couverture'])): ?>
        <p>
            <img src="<?= site_url('upload/' . $livre['nom_fichier_couverture']) ?>" alt="Couverture de <?= esc($livre['titre']) ?>" style="max-width: 240px; border-radius: 8px;">
        </p>
    <?php endif; ?>

    <hr>
    <h2>Dernier emprunt</h2>
    <?php if (! empty($dernierEmprunt)): ?>
        <p><strong>Emprunteur:</strong> <?= esc($dernierEmprunt['nom_emprunteur']) ?></p>
        <p><strong>Date d'emprunt:</strong> <?= esc($dernierEmprunt['date_emprunt']) ?></p>
        <p><strong>Date de retour:</strong> <?= esc((string) ($dernierEmprunt['date_retour'] ?? 'Non retourne')) ?></p>
    <?php else: ?>
        <p>Aucun emprunt enregistre pour ce livre.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
