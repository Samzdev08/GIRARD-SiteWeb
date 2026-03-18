<!-- ═══════════════════ HEADER ═══════════════════ -->
<section class="bg-dark text-white py-4 mb-4">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h1 class="fw-bold mb-1">Mes annonces</h1>
            <p class="text-white-50 mb-0">Gérez vos offres d'emploi publiées</p>
        </div>
        <a href="#" class="btn btn-accent rounded-pill px-4 fw-semibold add-annonce">
            <i class="bi bi-plus-lg me-2"></i>Nouvelle annonce
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

                            <!-- Statut + titre -->
                            <div class="col-12 col-md-5">
                                <span class="badge rounded-pill <?= $active ? 'bg-success' : 'bg-danger' ?> mb-2">
                                    <i class="bi bi-<?= $active ? 'check-circle' : 'x-circle' ?> me-1"></i>
                                    <?= $active ? 'Active' : 'Expirée' ?>
                                </span>
                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($annonce['title']) ?></h5>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Du <?= date('d F Y', strtotime($annonce['start_date'])) ?>
                                    au <?= date('d F Y', strtotime($annonce['end_date'])) ?>
                                </small>
                            </div>

                            <!-- Compétences -->
                            <div class="col-12 col-md-3">
                                <?php foreach (explode(',', $annonce['required_skills']) as $competence): ?>
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill me-1 mb-1">
                                        <?= htmlspecialchars(trim($competence)) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <!-- Wishlist -->
                            <div class="col-12 col-md-2 text-muted small">
                                <i class="bi bi-heart-fill text-danger me-1"></i>
                                <strong><?= $annonce['wishlist_count'] ?? 0 ?></strong> personne(s)
                            </div>

                            <!-- Actions -->
                            <div class="col-12 col-md-2 d-flex gap-2 justify-content-md-end flex-wrap">
                                <a class="btn btn-sm btn-outline-primary rounded-pill detail"
                                   href="/annonceur/details/<?= $annonce['id'] ?>">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-warning rounded-pill edit"
                                   href="/annonceur/edit/<?= $annonce['id'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/annonceur/delete/<?= $annonce['id'] ?>" method="POST"
                                      onsubmit="return confirm('Supprimer cette annonce ?')">
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="bi bi-trash"></i>
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
            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
            Aucune annonce créée. Commencez par en ajouter une !
        </div>
    <?php endif; ?>
</div>

<!-- ═══════════════════ MODAL ═══════════════════ -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalLabel">Détail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body pt-2" id="modalBody"></div>
        </div>
    </div>
</div>

<style>
    .btn-accent { background: #00c2ff; color: #0a1628; border: none; }
    .btn-accent:hover { background: #00aae0; color: #0a1628; }

    /* Champs dans le modal */
    #modalBody .form-label  { font-weight: 500; }
    #modalBody textarea     { min-height: 100px; }
</style>

<script src="/js/annonceur.js"></script>