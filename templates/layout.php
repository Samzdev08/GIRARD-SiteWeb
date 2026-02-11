<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Mon site Slim' ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<?php
session_start();
var_dump($_SESSION);
?>

<body>
    <header>
        <h1>S&FO - Search & Find jOb</h1>
        <nav>
            <a href="/">Accueil</a>
            <?php if ($_SESSION['type_compte'] === 'chercheur') : ?>
                <a href="/chercheur/dashboard">Profil Chercheur</a>
                <a href="/auth/logout">Déconnexion</a>
            <?php elseif ($_SESSION['type_compte'] === 'annonceur') : ?>
                <a href="/annonceur/dashboard">Profil Annonceur</a>
                <a href="/auth/logout">Déconnexion</a>
            <?php elseif ($_SESSION['type_compte'] === 'admin') : ?>
                <a href="/admin/dashboard">Coin Admin</a>
            <?php endif ?>
            <?php if (!isset($_SESSION['type_compte'])): ?>

                <a class="login" href="/auth/login">Connexion</a>
                <a class="register" href="/auth/register">Inscription</a>

            <?php endif ?>
        </nav>
    </header>
    <?= $content ?>
</body>

</html>