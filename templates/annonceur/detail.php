<div class="annonceur-detail">
    <div class="annonceur-header">
        <div class="annonceur-text">
            <h1>Mes annonces</h1>
            <p>Gérez vos offres d'emploi publiées</p>
        </div>
        <div class="annonceur-add">
            <a href="/annonceur/create">Nouvelle annonce</a>
        </div>
    </div>
    <div class="annonces-message"><?= $message ?></div>
    <div class="annonceur-list">

        <?php if (!empty($annonces)): ?>
            <?php foreach ($annonces as $annonce): ?>
                <div class="annonceur-item">
                    <div class="annonceur-statut">
                        <?= (strtotime($annonce['end_date']) > time()) ? "Active" : "Expirée" ?>
                    </div>

                    <div class="annonceur-info">
                        <h2><?php echo $annonce['title']; ?></h2>
                        <p>Du <?php echo date('d F Y', strtotime($annonce['start_date'])); ?> au <?php echo date('d F Y', strtotime($annonce['end_date'])); ?></p>
                    </div>
                    <div class="annonceur-competences">

                        <?php
                        $competences = explode(',', $annonce['required_skills']);

                        foreach ($competences as $competence): ?>
                            <span class="competence"><?= $competence ?></span>
                        <?php endforeach; ?>


                    </div>
                    <div class="annonceur-actions">
                        <a class="detail" href="/annonceur/details/1">Voir</a>
                        <a class="edit" href="/annonceur/edit/1">Modifier</a>
                        <form action="/annonceur/delete/1" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                            <button type="submit">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune annonce créée.</p>
        <?php endif; ?>
    </div>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>
</div>
<script src="/js/annonceur.js"></script>