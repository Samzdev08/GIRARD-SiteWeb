<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Mon site Slim' ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h1>S&FO - Search & Find jOb</h1>
        <nav>
            <a href="/">Accueil</a>
            <?php if ($_SESSION['user_type'] === 'etudiant') : ?>
                <a href="/chercheur/dashboard">Profil Etudiant</a>
            <?php elseif ($_SESSION['user_type'] === 'entreprise') : ?>
                <a href="/annonceur/dashboard">Profil Entreprise</a>
            <?php elseif ($_SESSION['user_type'] === 'admin') : ?>
                <a href="/admin/dashboard">Coin Admin</a>
            <?php endif ?>
            <?php if (!isset($_SESSION['user_type'])): ?>

                <a class="login" href="/auth/login">Connexion</a>
                <a class="register" href="/auth/register">Inscription</a>

            <?php endif ?>
        </nav>
    </header>
    <?= $content ?>
</body>

</html>