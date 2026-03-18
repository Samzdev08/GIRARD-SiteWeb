<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="fs-1 mb-2">😊</div>
                    <h3 class="fw-bold mb-1">Connexion</h3>
                    <p class="text-muted small">Connectez-vous à votre compte pour continuer.</p>
                </div>

                <!-- Erreurs -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3 py-2 mb-3">
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $error): ?>
                                <li class="small"><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Formulaire -->
                <form method="POST" action="/auth/login">

                    <div class="mb-3">
                        <label for="nomUtilisateur" class="form-label fw-medium">Nom d'utilisateur</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-person text-muted"></i>
                            </span>
                            <input type="text" id="nomUtilisateur" name="nomUtilisateur"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Entrez votre nom d'utilisateur" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="motdepasse" class="form-label fw-medium">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" id="motdepasse" name="motdepasse"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Entrez votre mot de passe" required>
                            <button type="button" class="btn btn-light border border-start-0"
                                    id="togglePassword" tabindex="-1">
                                <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                    </button>

                </form>

                <!-- Footer -->
                <p class="text-center text-muted small mt-4 mb-0">
                    Pas encore de compte ?
                    <a href="/auth/register" class="text-primary fw-semibold text-decoration-none">Inscrivez-vous</a>
                </p>
            </div>

            <!-- Retour -->
            <div class="text-center mt-3">
                <a href="/" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Retour à l'accueil
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('motdepasse');
        const icon  = document.getElementById('eyeIcon');
        const isHidden = input.type === 'password';
        input.type     = isHidden ? 'text' : 'password';
        icon.className = isHidden ? 'bi bi-eye-slash text-muted' : 'bi bi-eye text-muted';
    });
</script>