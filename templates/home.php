<link rel="stylesheet" href="/css/home.css">
<div class="tile-container">

    <h1>Trouvez le job de vos rêves</h1>
    <p>Des milliers d'annonces vous attendent sur notre plateforme.</p>
    <div class="search-container">
        <form action="/search" method="GET">
            <input type="text" name="query" placeholder="Rechercher un job, une compétence, un mot-clé..." required>
            <button type="submit">Rechercher</button>
        </form>
    </div>
</div>
<div class="stats-container">

    <div class="stats">
        <div class="emoji">👩‍💻</div>
        <div class="numb">250+</div>
        <div class="desc">Offres d'emploi disponibles</div>
    </div>
    <div class="stats">
        <div class="emoji">👩‍💻</div>
        <div class="numb">250+</div>
        <div class="desc">Offres d'emploi disponibles</div>
    </div>
    <div class="stats">
        <div class="emoji">👩‍💻</div>
        <div class="numb">250+</div>
        <div class="desc">Offres d'emploi disponibles</div>
    </div>
</div>
<div class="offres-container">

    <h1>Offres récentes</h1>
    <p>Découvrez les dernières offres d'emploi publiées sur notre plateforme.</p>
    <div class="offres-list">

        <?php if (!empty($annonces)): ?>
            <?php foreach ($annonces as $annonce): ?>
                <div class="offre">
                    <div class="container-like">
                        <div class="like-button">❤️<span>0</span></div>
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
    </div>
    <div class="voir-plus">
        <a href="/offres">Voir plus d'offres</a>
    </div>
    <?php else: ?>
        <p class="message">Aucune annonce disponible pour le moment.</p>
    <?php endif; ?>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>

</div>
<script src="/js/home.js"></script>
