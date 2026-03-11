<link rel="stylesheet" href="/css/style.css">
<div class="offres-container">
    <h1>Toutes les offres d'emploi</h1>
    <p>Découvrez toutes les offres d'emploi disponibles sur notre plateforme.</p>
</div>
<div class="main-container">
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Rechercher par titre, description ou compétences...">
        <button id="searchButton">Rechercher</button>
    </div>
    <div class="offres-list" id="offresList">
        <?php if (!empty($annonces)): ?>
            <?php foreach ($annonces as $annonce): ?>
                <div class="offre">
                    <div class="container-like">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php $inWishlist = !empty($annonce['in_wishlist']); ?>
                            <form action="/chercheur/wishlist/<?= $inWishlist ? 'remove' : 'add' ?>/<?= $annonce['id'] ?>" method="POST" class="wishlist-form">
                                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                <button type="submit" class="like-button <?= $inWishlist ? 'wishlisted' : '' ?>">
                                    <?= $inWishlist ? '❤️' : '🤍' ?><span><?= $annonce['wishlist_count'] ?? 0 ?></span>
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="/auth/login" class="like-button">🤍<span><?= $annonce['wishlist_count'] ?? 0 ?></span></a>
                        <?php endif; ?>
                        <div class="title"><?= $annonce['title'] ?></div>
                        <div class="infos">
                            <div class="date-posted">Posté le <?= $annonce['created_at'] ?></div>
                        </div>
                        <div class="description">
                            <?= $annonce['description'] ?>
                        </div>
                        <div class="comptences">
                            <?php $competences = explode(',', $annonce['required_skills']);
                            foreach ($competences as $competence): ?>
                                <span class="competence"><?= trim($competence) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a class="detail" href="/details/<?= $annonce['id'] ?>">Voir l'offre</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="message">Aucune annonce disponible pour le moment.</p>
        <?php endif; ?>
         <p class="message-search">Aucune annonce corrospondante pour ce mot-clé. Essayé un autre</p>
    </div>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>
</div>
<script src="/js/list.js"></script>