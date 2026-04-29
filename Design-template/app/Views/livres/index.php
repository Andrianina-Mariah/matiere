<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="top-actions">
        <h1>Catalogue des livres</h1>
        <a class="btn btn-primary" href="<?= site_url('/livre/create') ?>">Nouveau livre</a>
    </div>

    <form method="get" action="<?= site_url('/livre') ?>" class="row" style="margin-bottom:12px;">
        <div class="field">
            <label for="q">Mot-cle (titre)</label>
            <input id="q" name="q" type="text" value="<?= esc($q ?? '') ?>" placeholder="Ex: PHP">
        </div>
        <div class="field">
            <label for="categorie">Categorie</label>
            <select id="categorie" name="categorie">
                <option value="">Toutes</option>
                <?php foreach (($categories ?? []) as $cat): ?>
                    <option value="<?= esc($cat) ?>" <?= (($categorieSelectionnee ?? '') === $cat) ? 'selected' : '' ?>>
                        <?= esc($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Rechercher</button>
            <a class="btn" href="<?= site_url('/livre') ?>">Reinitialiser</a>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Annee</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($livres)): ?>
                <tr><td colspan="5">Aucun livre trouve.</td></tr>
            <?php endif; ?>

            <?php foreach ($livres as $livre): ?>
                <tr>
                    <td>
                        <a href="<?= site_url('/livre/' . (int) $livre['identifiant']) ?>">
                            <?= esc($livre['titre']) ?>
                        </a>
                    </td>
                    <td><?= esc($livre['auteur']) ?></td>
                    <td><?= esc((string) $livre['annee_publication']) ?></td>
                    <td>
                        <?php $estDisponible = (($livre['statut'] ?? '') === 'disponible'); ?>
                        <span class="badge <?= $estDisponible ? 'badge-ok' : 'badge-ko' ?>">
                            <?= $estDisponible ? 'Disponible' : 'Prete' ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($estDisponible): ?>
                            <form class="inline" method="post" action="<?= site_url('/livre/pret/' . (int) $livre['identifiant']) ?>">
                                <?= csrf_field() ?>
                                <input type="text" name="nom_emprunteur" placeholder="Nom emprunteur" required>
                                <button class="btn btn-warning" type="submit">Preter</button>
                            </form>
                        <?php else: ?>
                            <form class="inline" method="post" action="<?= site_url('/livre/retour/' . (int) $livre['identifiant']) ?>">
                                <?= csrf_field() ?>
                                <button class="btn btn-success" type="submit">Retourner</button>
                            </form>
                        <?php endif; ?>

                        <form class="inline" method="post" action="<?= site_url('/livre/delete/' . (int) $livre['identifiant']) ?>" onsubmit="return confirm('Supprimer ce livre ?');">
                            <?= csrf_field() ?>
                            <button class="btn btn-danger" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 12px;">
        <?= $pager->links('livres', 'default_full') ?>
    </div>
</div>

<?= $this->endSection() ?>
