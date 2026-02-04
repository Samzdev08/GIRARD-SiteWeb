<div class="form-container">
    <div class="emoji">😊</div>
    <div class="title">Créer un compte</div>
    <p>Rejoignez notre plateforme en créant un compte dès aujourd'hui !</p>

    <form method="POST" action="/auth/register">
        <div class="type-comptes">
            <label for="type-compte">Type de compte :</label>
            <div class="type-container">
                <div class="type" data-type="chercheur" style="border: 1px solid red;">
                    <div class="emoji">🔍</div>
                    <div class="label">Chercheur</div>
                    <div class="desc">Je cherche un emploi</div>
                </div>
                <div class="type" data-type="annonceur">
                    <div class="emoji">📢</div>
                    <div class="label">Annonceur</div>
                    <div class="desc">Je propose une offre d'emploi</div>
                </div>
            </div>
            <input type="hidden" id="type-compte" name="type-compte" value="" >
        </div>
        <div class="input-group">
            <label for="nomUtilisateur">Nom d'utilisateur :</label>
            <input type="text" id="nomUtilisateur" name="nomUtilisateur" placeholder="Entrez votre nom d'utilisateur" >
            <small>Au moins 3 caractères</small>
        </div>
        <div class="input-group">
            <label for="motdepasse">Mot de passe :</label>
            <input type="password" id="motdepasse" name="motdepasse" placeholder="Entrez votre mot de passe" >
            <small class="passwd">Au moins 6 caractères</small>
        </div>
        <button type="submit">Créer mon compte</button>
    </form>
</div>
<a href="/">Retour à l'accueil</a>

<ul style="text-align: center; list-style: none;">
    <?php if (!empty($errors)) :
        foreach ($errors as $error): ?>
            <li style="color: red; font-size:14px "><?= $error ?></li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeElements = document.querySelectorAll('.type');
        const typeInput = document.getElementById('type-compte');

        typeElements.forEach(element => {
            element.addEventListener('click', function() {
                typeElements.forEach(el =>

                    el.classList.remove('selected'));
                this.classList.add('selected');
                typeInput.value = this.getAttribute('data-type');

            });
        });
    });
</script>