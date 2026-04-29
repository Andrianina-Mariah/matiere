<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Releve de notes') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/design.css') ?>">
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">RN</div>
            <div>
                <div class="brand-name">Releve Notes</div>
                <div class="brand-sub">S3 / S4</div>
            </div>
        </div>

        <div class="sidebar-section">Navigation</div>
        <a href="<?= site_url('/etudiants') ?>" class="nav-item">
            <span class="nav-dot"></span> Etudiants
        </a>
        <a href="<?= site_url('/notes/create') ?>" class="nav-item">
            <span class="nav-dot"></span> Ajouter une note
        </a>
        <a href="<?= site_url('/notes') ?>" class="nav-item">
            <span class="nav-dot"></span> Liste des notes
        </a>

        <div class="sidebar-bottom">
            <div class="user-row">
                <div class="avatar">
                    <?= esc(strtoupper(substr((string) session()->get('username'), 0, 2))) ?>
                </div>
                <div class="user-info">
                    <div class="name"><?= esc((string) session()->get('username')) ?></div>
                    <a class="logout" href="<?= site_url('/logout') ?>">Se deconnecter</a>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-title"><?= esc($title ?? 'Tableau') ?></div>
        </div>

        <main class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>
</body>
</html>
