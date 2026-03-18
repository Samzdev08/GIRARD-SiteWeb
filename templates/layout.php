<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'S&FO - Search & Find jOb' ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sfо-primary:   #0d6efd;
            --sfо-dark:      #0a1628;
            --sfо-accent:    #00c2ff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fb;
        }

        /* ── Navbar ── */
        .navbar {
            background: var(--sfо-dark);
            box-shadow: 0 2px 12px rgba(0,0,0,.25);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: #fff !important;
            letter-spacing: .5px;
        }

        .navbar-brand span {
            color: var(--sfо-accent);
        }

        .nav-link {
            color: rgba(255,255,255,.80) !important;
            font-weight: 500;
            transition: color .2s;
        }

        .nav-link:hover {
            color: var(--sfо-accent) !important;
        }

        .btn-nav-login {
            border: 1.5px solid var(--sfо-accent);
            color: var(--sfо-accent) !important;
            border-radius: 20px;
            padding: 4px 18px;
            font-weight: 600;
            transition: background .2s, color .2s;
        }

        .btn-nav-login:hover {
            background: var(--sfо-accent);
            color: var(--sfо-dark) !important;
        }

        .btn-nav-register {
            background: var(--sfо-accent);
            color: var(--sfо-dark) !important;
            border-radius: 20px;
            padding: 4px 18px;
            font-weight: 600;
            transition: opacity .2s;
        }

        .btn-nav-register:hover {
            opacity: .85;
        }

        .nav-link-logout {
            color: #ff6b6b !important;
        }

        .nav-link-logout:hover {
            color: #ff4444 !important;
        }
    </style>
</head>
<body>

<!-- ════════════════════════════════════ NAVBAR ════════════════════════════════════ -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="/">
            <i class="bi bi-briefcase-fill me-2"></i>S&amp;<span>FO</span>
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/"><i class="bi bi-house me-1"></i>Accueil</a>
                </li>

                <?php if (($_SESSION['type_compte'] ?? '') === 'chercheur'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/chercheur/dashboard">
                            <i class="bi bi-person-circle me-1"></i>Mon profil
                        </a>
                    </li>

                <?php elseif (($_SESSION['type_compte'] ?? '') === 'annonceur'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/annonceur/dashboard">
                            <i class="bi bi-building me-1"></i>Mon espace
                        </a>
                    </li>

                <?php elseif (($_SESSION['type_compte'] ?? '') === 'administrateur'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">
                            <i class="bi bi-shield-lock me-1"></i>Administration
                        </a>
                    </li>
                <?php endif ?>
            </ul>

            <!-- Right-side actions -->
            <ul class="navbar-nav align-items-center gap-2">
                <?php if (!empty($_SESSION['type_compte'])): ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-logout" href="/auth/logout">
                            <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn-nav-login" href="/auth/login">
                            <i class="bi bi-person me-1"></i>Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-nav-register" href="/auth/register">
                            <i class="bi bi-person-plus me-1"></i>Inscription
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
<!-- ══════════════════════════════════════════════════════════════════════════════════ -->

<!-- Page content -->
<main>
    <?= $content ?>
</main>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>