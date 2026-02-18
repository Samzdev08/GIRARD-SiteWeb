
<div class="annonceur-detail">
    <div class="annonceur-header">
        <div class="annonceur-text">
            <h1>Mes annonces</h1>
            <p>Gérez vos offres d'emploi publiées</p>
        </div>
        <div class="annonceur-add">
            <a href="#" class="add-annonce">Nouvelle annonce</a>
        </div>
    </div>
    <?php if (!empty($message)): ?>
        <div class="message <?= $type ?>"><?= $message ?></div>
    <?php endif; ?>

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
                        <a class="detail" href="/annonceur/details/<?= $annonce['id'] ?>">Voir</a>
                        <a class="edit" href="/annonceur/edit/<?= $annonce['id'] ?>">Modifier</a>
                        <form action="/annonceur/delete/<?= $annonce['id'] ?>" method="POST">
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