<div class="form-container">
    <div class="emoji">😊</div>
    <div class="title">Connexion</div>
    <p>Connectez-vous à votre compte pour continuer.</p>

    <form method="POST" action="/auth/login">
        
            <div class="input-group">
                <label for="nomUtilisateur">Nom d'utilisateur :</label>
                <input type="text" id="nomUtilisateur" name="nomUtilisateur" placeholder="Entrez votre nom d'utilisateur" required>
            </div>
            <div class="input-group">
                <label for="motdepasse">Mot de passe :</label>
                <input type="password" id="motdepasse" name="motdepasse" placeholder="Entrez votre mot de passe" required>
            </div>
           
        <button type="submit">Se connecter</button>
        <span>Vous n'avez pas de compte ? <a href="/register">Inscrivez-vous</a></span>
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