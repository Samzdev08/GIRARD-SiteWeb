<?php

use App\Models\Annonce;
?>
<!-- ═══════════════════ HEADER ═══════════════════ -->
<section class="bg-dark text-white py-4 mb-4">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h1 class="fw-bold mb-1"><i class="bi bi-heart-fill text-danger me-2"></i>Ma Wishlist</h1>
            <p class="text-white-50 mb-0">Gérez vos offres d'emploi sauvegardées</p>
            <p class="text-white-50 mt-2"><?= count($annonces) ?> Annonces trouvées</p>
        </div>
        <a href="/" class="btn btn-accent rounded-pill px-4 fw-semibold">
            <i class="bi bi-grid me-2"></i>Voir les offres
        </a>
    </div>
</section>

<div class="container pb-5">

    <!-- Flash message -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show message" role="alert">
            <i class="bi bi-<?= $type === 'success' ? 'check-circle' : 'exclamation-triangle' ?>-fill me-2"></i>
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Liste -->
    <?php if (!empty($annonces)): ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach ($annonces as $annonce):
                $active = strtotime($annonce['end_date']) > time();
            ?>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center g-3">

                            <!-- Statut + titre + dates -->
                            <div class="col-12 col-md-5">
                                <span class="badge rounded-pill <?= $active ? 'bg-success' : 'bg-secondary' ?> mb-2">
                                    <i class="bi bi-<?= $active ? 'check-circle' : 'x-circle' ?> me-1"></i>
                                    <?= $active ? 'Active' : 'Expirée' ?>
                                </span>
                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($annonce['title']) ?></h5>
                                <small class="text-muted d-block">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Du <?= date('d F Y', strtotime($annonce['start_date'])) ?>
                                    au <?= date('d F Y', strtotime($annonce['end_date'])) ?>
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-bookmark me-1"></i>
                                    Sauvegardé le <?= date('d F Y', strtotime($annonce['wishlist_date'])) ?>
                                </small>
                            </div>

                            <!-- Compétences -->
                            <div class="col-12 col-md-4">
                                <?php foreach (explode(',', $annonce['required_skills']) as $competence): ?>
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill me-1 mb-1">
                                        <?= htmlspecialchars(trim($competence)) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <!-- Actions -->
                            <div class="col-12 col-md-3 d-flex gap-2 justify-content-md-end flex-wrap">
                                <a class="btn btn-sm btn-outline-primary rounded-pill detail"
                                   href="/details/<?= $annonce['id'] ?>">
                                    <i class="bi bi-eye me-1"></i>Voir
                                </a>
                                <form action="/chercheur/wishlist/remove/<?= $annonce['id'] ?>" method="POST">
                                    <input type="hidden" name="redirect" value="/chercheur/dashboard">
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="bi bi-heart-slash me-1"></i>Retirer
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary text-center py-5">
            <i class="bi bi-heart fs-3 d-block mb-2"></i>
            Aucune annonce sauvegardée. <a href="/" class="alert-link">Parcourir les offres</a>
        </div>
    <?php endif; ?>
</div>

<!-- ═══════════════════ MODAL ═══════════════════ -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalLabel">Détail de l'offre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body pt-2" id="modalBody"></div>
        </div>
    </div>
</div>

<style>
    .btn-accent { background: #00c2ff; color: #0a1628; border: none; }
    .btn-accent:hover { background: #00aae0; color: #0a1628; }
</style>

<script src="/js/chercheur.js"></script>