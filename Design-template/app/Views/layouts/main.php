<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Bibliotheque') ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f7fb; color: #1f2937; }
        .container { max-width: 1100px; margin: 0 auto; padding: 16px; }
        nav { background: #0f172a; color: #fff; }
        nav .container { display: flex; gap: 16px; align-items: center; }
        nav a { color: #fff; text-decoration: none; padding: 10px 0; }
        nav a:hover { text-decoration: underline; }
        .card { background: #fff; border-radius: 10px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .alert { padding: 10px 12px; border-radius: 8px; margin-bottom: 12px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .btn { border: none; border-radius: 6px; padding: 8px 12px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-warning { background: #ea580c; color: #fff; }
        .btn-success { background: #16a34a; color: #fff; }
        .badge { padding: 4px 8px; border-radius: 999px; font-size: 12px; font-weight: bold; }
        .badge-ok { background: #dcfce7; color: #166534; }
        .badge-ko { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        form.inline { display: inline-flex; gap: 8px; align-items: center; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; }
        .row { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 12px; }
        .field { margin-bottom: 12px; }
        .error { color: #b91c1c; font-size: 13px; margin-top: 4px; }
        .top-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; gap: 10px; flex-wrap: wrap; }
        @media (max-width: 768px) {
            .row { grid-template-columns: 1fr; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            td { border: none; border-bottom: 1px solid #e5e7eb; }
        }
    </style>
</head>
<body>
<nav>
    <div class="container">
        <strong>Bibliotheque</strong>
        <a href="<?= site_url('/livre') ?>">Catalogue</a>
        <a href="<?= site_url('/livre/create') ?>">Ajouter un livre</a>
    </div>
</nav>

<main class="container">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</main>
</body>
</html>
