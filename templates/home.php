<link rel="stylesheet" href="/css/style.css">
<div class="tile-container">
    <h1>Trouvez le job de vos rêves</h1>
    <p>Des milliers d'annonces vous attendent sur notre plateforme.</p>
    <div class="search-container">
        <form action="/search" method="GET">
            <input type="text" class="search-bar" name="query" placeholder="Rechercher un job, une compétence, un mot-clé..." required>
            <button type="submit">Rechercher</button>
        </form>
    </div>
</div>
<div class="stats-container">
    <div class="stats">
        <div class="emoji"><svg width="120" height="120" viewBox="0 0 24 24" fill="#2B2B2B">
      <circle cx="12" cy="7" r="3" />
      <path d="M6 19c0-3 2.5-5 6-5s6 2 6 5v1H6v-1z" />
      <rect x="4" y="15" width="16" height="3" rx="0.5" />
    </svg></div>
        <div class="numb">250+</div>
        <div class="desc">Offres d'emploi disponibles</div>
    </div>
    <div class="stats">
        <div class="emoji"><svg width="120" height="120" viewBox="0 0 24 24" fill="#2B2B2B">
      <circle cx="12" cy="7" r="3" />
      <path d="M6 19c0-3 2.5-5 6-5s6 2 6 5v1H6v-1z" />
      <rect x="4" y="15" width="16" height="3" rx="0.5" />
    </svg></div>
        <div class="numb">250+</div>
        <div class="desc">Offres d'emploi disponibles</div>
    </div>
    <div class="stats">
        <div class="emoji"> <svg width="120" height="120" viewBox="0 0 24 24" fill="#2B2B2B">
      <circle cx="12" cy="7" r="3" />
      <path d="M6 19c0-3 2.5-5 6-5s6 2 6 5v1H6v-1z" />
      <rect x="4" y="15" width="16" height="3" rx="0.5" />
    </svg></div>
        <div class="numb">250+</div>
        <div class="desc">Offres d'emploi disponibles</div>
    </div>
</div>

<?php if (!empty($message)): ?>
    <div class="message <?= $type ?>"><?= $message ?></div>
<?php endif; ?>

<div class="offres-container">
    <h1><?php echo $nombreOffre ?> offre(s) trouvée(s)</h1>
    <p>Découvrez les dernières offres d'emploi publiées sur notre plateforme.</p>
    <div class="offres-list">
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
        <div class="voir-plus">
            <a href="/offres">Voir plus d'offres</a>
        </div>
        <?php else: ?>
            <p class="message">Aucune annonce disponible pour le moment.</p>
        <?php endif; ?>
        <p class="message-search">Aucune annonce corrospondante pour ce mot-clé. Essayé un autre</p>
    </div>
</div>
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <div id="modalBody"></div>
    </div>
</div>
<script src="/js/home.js"></script>