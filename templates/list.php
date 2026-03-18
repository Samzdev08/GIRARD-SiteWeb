<!-- ═══════════════════════ HERO ═══════════════════════ -->
<section class="bg-dark text-white py-4 mb-4">
    <div class="container">
        <h1 class="fw-bold mb-1">Toutes les offres d'emploi</h1>
        <p class="text-white-50 mb-0">Découvrez toutes les offres d'emploi disponibles sur notre plateforme.</p>
    </div>
</section>

<div class="container pb-5">

    <!-- Barre de recherche -->
    <div class="row mb-4">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="searchInput"
                       class="form-control border-start-0 ps-0"
                       placeholder="Rechercher par titre, description ou compétences...">
                <button class="btn btn-primary px-4" id="searchButton">
                    Rechercher
                </button>
            </div>
        </div>
    </div>

    <!-- Message recherche vide -->
    <div class="alert alert-warning d-none message-search" role="alert">
        <i class="bi bi-search me-2"></i>
        Aucune annonce correspondante pour ce mot-clé. Essayez un autre.
    </div>

    <!-- Liste des offres -->
    <div class="row g-4 offres-list" id="offresList">
        <?php if (!empty($annonces)): ?>
            <?php foreach ($annonces as $annonce): ?>
                <?php $inWishlist = !empty($annonce['in_wishlist']); ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card offre-card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body d-flex flex-column p-4">

                            <!-- Titre + like -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-semibold mb-0"><?= htmlspecialchars($annonce['title']) ?></h5>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <form action="/chercheur/wishlist/<?= $inWishlist ? 'remove' : 'add' ?>/<?= $annonce['id'] ?>"
                                          method="POST" class="wishlist-form ms-2 flex-shrink-0">
                                        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                        <button type="submit"
                                                class="btn btn-sm <?= $inWishlist ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill like-button">
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
                            <div class="mb-3">
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

<!-- ═══════════════════════ MODAL ═══════════════════════ -->
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
    .offre-card {
        transition: transform .2s, box-shadow .2s;
    }
    .offre-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 32px rgba(0,0,0,.10) !important;
    }
    .description {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script src="/js/list.js"></script>