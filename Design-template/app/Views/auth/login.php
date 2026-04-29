<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Releve de notes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/design.css') ?>">
</head>
<body class="login-body">
<div class="login-shell">
    <div class="login-card">
        <div class="login-brand">
            <div class="logo-icon">RN</div>
            <div>
                <h1>Releve de notes</h1>
                <span>Gestion S3 / S4</span>
            </div>
        </div>

        <h2>Connexion</h2>
        <p class="subtitle">Saisissez vos identifiants pour acceder au relevé.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('/login') ?>">
            <?= csrf_field() ?>

            <div class="field-group">
                <label for="username">Nom d'utilisateur</label>
                <input id="username" type="text" name="username" value="<?= esc(old('username') ?? 'admin') ?>" required>
            </div>

            <div class="field-group">
                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" value="<?= esc(old('password') ?? 'admin') ?>" required>
            </div>

            <button class="btn btn-primary btn-full" type="submit">Se connecter</button>
        </form>
    </div>
    <div class="login-panel">
        <div>
            <h3>Suivi harmonise</h3>
            <p>Visualisez les notes par semestre, parcours et moyenne generale.</p>
        </div>
    </div>
</div>
</body>
</html>
