<link rel="stylesheet" href="/css/style.css">
<div class="chercheur-detail">
    <div class="chercheur-header">
        <div class="chercheur-text">
            <h1>Ma Wishlist</h1>
            <p>Gérez vos offres d'emploi sauvegardées</p>
        </div>
        <div class="chercheur-add">
            <a href="/" class="btn-offres">Voir les offres</a>
        </div>
    </div>
    <?php if (!empty($message)): ?>
        <div class="message <?= $type ?>"><?= $message ?></div>
    <?php endif; ?>
    <div class="chercheur-list">
        <?php if (!empty($annonces)): ?>
            <?php foreach ($annonces as $annonce): ?>
                <div class="chercheur-item">
                    <div class="chercheur-statut">
                        <?= (strtotime($annonce['end_date']) > time()) ? "Active" : "Expirée" ?>
                    </div>
                    <div class="chercheur-info">
                        <h2><?= $annonce['title'] ?></h2>
                        <p>Du <?= date('d F Y', strtotime($annonce['start_date'])) ?> au <?= date('d F Y', strtotime($annonce['end_date'])) ?></p>
                        <p class="chercheur-wishlist-date">Sauvegardé le <?= date('d F Y', strtotime($annonce['wishlist_date'])) ?></p>
                    </div>
                    <div class="chercheur-competences">
                        <?php
                        $competences = explode(',', $annonce['required_skills']);
                        foreach ($competences as $competence): ?>
                            <span class="competence"><?= trim($competence) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="chercheur-actions">
                        <a class="detail" href="/details/<?= $annonce['id'] ?>">Voir l'offre</a>
                        <form action="/chercheur/wishlist/remove/<?= $annonce['id'] ?>" method="POST">
                            <input type="hidden" name="redirect" value="/chercheur/dashboard">
                            <button type="submit">Retirer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune annonce sauvegardée.</p>
        <?php endif; ?>
    </div>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>
</div>
<script src="/js/chercheur.js"></script>