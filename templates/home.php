<!-- ═══════════════════════════════ HERO ═══════════════════════════════ -->
<section class="hero-section py-5 text-white text-center">
    <div class="container py-4">
        <h1 class="display-5 fw-bold mb-3">Trouvez le job de vos rêves</h1>
        <p class="lead mb-4 text-white-50">Des milliers d'annonces vous attendent sur notre plateforme.</p>
        <form action="/search" method="GET" class="row justify-content-center g-2">
            <div class="col-12 col-md-8 col-lg-6">
                <input type="text" class="form-control form-control-lg search-bar" name="query"
                       placeholder="Rechercher un job, une compétence, un mot-clé..." required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-accent btn-lg">
                    <i class="bi bi-search me-1"></i>Rechercher
                </button>
            </div>
        </form>
    </div>
</section>

<!-- ══════════════════════════════ STATS ══════════════════════════════ -->
<section class="stats-section py-5 bg-white border-bottom">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-12 col-md-4">
                <div class="stat-card p-4 rounded-4 h-100">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-briefcase-fill fs-1 text-primary"></i>
                    </div>
                    <div class="display-6 fw-bold text-primary">250+</div>
                    <div class="text-muted mt-1">Offres d'emploi disponibles</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card p-4 rounded-4 h-100">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-people-fill fs-1 text-primary"></i>
                    </div>
                    <div class="display-6 fw-bold text-primary">1 200+</div>
                    <div class="text-muted mt-1">Candidats inscrits</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card p-4 rounded-4 h-100">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-building-fill-check fs-1 text-primary"></i>
                    </div>
                    <div class="display-6 fw-bold text-primary">80+</div>
                    <div class="text-muted mt-1">Entreprises partenaires</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════ FLASH ══════════════════════════════ -->
<?php if (!empty($message)): ?>
    <div class="container mt-4">
        <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <i class="bi bi-<?= $type === 'success' ? 'check-circle' : 'exclamation-triangle' ?>-fill me-2"></i>
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<!-- ═══════════════════════════════ OFFRES ════════════════════════════ -->
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h2 class="fw-bold mb-0 offres-titre">
                <?= $nombreOffre ?> offre(s) trouvée(s)
            </h2>
        </div>
        <p class="text-muted mb-4">Découvrez les dernières offres d'emploi publiées sur notre plateforme.</p>

        <!-- Message recherche vide -->
        <div class="alert alert-warning d-none message-search" role="alert">
            <i class="bi bi-search me-2"></i>
            Aucune annonce correspondante pour ce mot-clé. Essayez un autre.
        </div>

        <!-- Liste des offres -->
        <div class="row g-4 offres-list">
            <?php if (!empty($annonces)): ?>
                <?php foreach ($annonces as $annonce): ?>
                    <?php $inWishlist = !empty($annonce['in_wishlist']); ?>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card offre-card h-100 border-0 shadow-sm rounded-4">
                            <div class="card-body d-flex flex-column p-4">

                                <!-- Header : titre + like -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-semibold mb-0 title"><?= htmlspecialchars($annonce['title']) ?></h5>

                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <form action="/chercheur/wishlist/<?= $inWishlist ? 'remove' : 'add' ?>/<?= $annonce['id'] ?>"
                                              method="POST" class="wishlist-form ms-2 flex-shrink-0">
                                            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                            <button type="submit"
                                                    class="btn btn-sm like-button <?= $inWishlist ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill">
                                                <i class="bi bi-heart<?= $inWishlist ? '-fill' : '' ?>"></i>
                                                <span class="ms-1"><?= $annonce['wishlist_count'] ?? 0 ?></span>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a href="/auth/login"
                                           class="btn btn-sm btn-outline-danger rounded-pill like-button ms-2 flex-shrink-0">
                                            <i class="bi bi-heart"></i>
                                            <span class="ms-1"><?= $annonce['wishlist_count'] ?? 0 ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- Date -->
                                <small class="text-muted mb-3">
                                    <i class="bi bi-calendar3 me-1"></i>Posté le <?= $annonce['created_at'] ?>
                                </small>

                                <!-- Description -->
                                <p class="card-text text-muted small flex-grow-1 description">
                                    <?= htmlspecialchars($annonce['description']) ?>
                                </p>

                                <!-- Compétences -->
                                <div class="mb-3 comptences">
                                    <?php foreach (explode(',', $annonce['required_skills']) as $competence): ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill me-1 mb-1 competence">
                                            <?= htmlspecialchars(trim($competence)) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                                <!-- CTA -->
                                <a class="btn btn-outline-primary rounded-pill detail mt-auto"
                                   href="/details/<?= $annonce['id'] ?>">
                                    Voir l'offre <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Voir plus -->
                <div class="col-12 text-center mt-2">
                    <a href="/offres" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-grid me-2"></i>Voir plus d'offres
                    </a>
                </div>

            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-secondary text-center">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        Aucune annonce disponible pour le moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════ MODAL ════════════════════════════ -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalLabel">Détail de l'offre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body pt-2" id="modalBody"></div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hero */
    .hero-section {
        background: linear-gradient(135deg, #0a1628 0%, #0d6efd 100%);
    }
    .btn-accent {
        background: #00c2ff;
        color: #0a1628;
        font-weight: 700;
        border: none;
    }
    .btn-accent:hover { background: #00aae0; color: #0a1628; }

    /* Stats */
    .stat-card {
        background: #f8f9fb;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(13,110,253,.12); }

    /* Offre cards */
    .offre-card {
        transition: transform .2s, box-shadow .2s;
    }
    .offre-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(0,0,0,.10) !important; }

    .description {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script src="/js/home.js"></script>