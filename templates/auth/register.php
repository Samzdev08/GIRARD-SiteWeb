<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="fs-1 mb-2">😊</div>
                    <h3 class="fw-bold mb-1">Créer un compte</h3>
                    <p class="text-muted small">Rejoignez notre plateforme en créant un compte dès aujourd'hui !</p>
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
                <form method="POST" action="/auth/register">

                    <!-- Type de compte -->
                    <div class="mb-4">
                        <label class="form-label fw-medium">Type de compte</label>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="type-card text-center p-3 rounded-3 border border-2 cursor-pointer"
                                     data-type="chercheur" id="card-chercheur">
                                    <div class="fs-3 mb-1">🔍</div>
                                    <div class="fw-semibold small">Chercheur</div>
                                    <div class="text-muted" style="font-size:.75rem">Je cherche un emploi</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="type-card text-center p-3 rounded-3 border border-2 cursor-pointer"
                                     data-type="annonceur" id="card-annonceur">
                                    <div class="fs-3 mb-1">📢</div>
                                    <div class="fw-semibold small">Annonceur</div>
                                    <div class="text-muted" style="font-size:.75rem">Je propose une offre</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="type-compte" name="type-compte" value="">
                        <div class="invalid-feedback d-none mt-1 type-error small text-danger">
                            Veuillez sélectionner un type de compte.
                        </div>
                    </div>

                    <!-- Nom d'utilisateur -->
                    <div class="mb-3">
                        <label for="nomUtilisateur" class="form-label fw-medium">Nom d'utilisateur</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-person text-muted"></i>
                            </span>
                            <input type="text" id="nomUtilisateur" name="nomUtilisateur"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Entrez votre nom d'utilisateur"
                                   value="<?= htmlspecialchars($username ?? '') ?>">
                        </div>
                        <div class="form-text">Au moins 3 caractères.</div>
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-4">
                        <label for="motdepasse" class="form-label fw-medium">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" id="motdepasse" name="motdepasse"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Entrez votre mot de passe">
                            <button type="button" class="btn btn-light border border-start-0"
                                    id="togglePassword" tabindex="-1">
                                <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                            </button>
                        </div>
                        <div class="form-text">Au moins 6 caractères.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-person-plus me-2"></i>Créer mon compte
                    </button>

                </form>

                <!-- Footer -->
                <p class="text-center text-muted small mt-4 mb-0">
                    Déjà un compte ?
                    <a href="/auth/login" class="text-primary fw-semibold text-decoration-none">Connectez-vous</a>
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

<style>
    .type-card {
        cursor: pointer;
        transition: border-color .2s, background .2s, transform .15s;
        border-color: #dee2e6 !important;
    }
    .type-card:hover {
        border-color: #0d6efd !important;
        background: #f0f6ff;
        transform: translateY(-2px);
    }
    .type-card.selected {
        border-color: #0d6efd !important;
        background: #e7f1ff;
    }
    .type-card.selected .fw-semibold {
        color: #0d6efd;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Sélection du type de compte ──
    const typeCards = document.querySelectorAll('.type-card');
    const typeInput = document.getElementById('type-compte');

    typeCards.forEach(card => {
        card.addEventListener('click', function () {
            typeCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            typeInput.value = this.dataset.type;
            document.querySelector('.type-error')?.classList.add('d-none');
        });
    });

    // Validation : forcer le choix du type avant soumission
    document.querySelector('form').addEventListener('submit', function (e) {
        if (!typeInput.value) {
            e.preventDefault();
            document.querySelector('.type-error')?.classList.remove('d-none');
            document.getElementById('card-chercheur').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // ── Afficher / masquer le mot de passe ──
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('motdepasse');
        const icon  = document.getElementById('eyeIcon');
        const isHidden = input.type === 'password';
        input.type     = isHidden ? 'text' : 'password';
        icon.className = isHidden ? 'bi bi-eye-slash text-muted' : 'bi bi-eye text-muted';
    });
});
</script>