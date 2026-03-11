# Journal de bord 
### lien du rapport de test : https://docs.google.com/spreadsheets/d/1xJxyJq9bZRFFxvoRA4Ii3Y5YiuEe80j6oIEHq0L34M0/edit?gid=36809425#gid=36809425

### lien du planing : https://docs.google.com/spreadsheets/d/1pgZ-EXmahRv91h59EzFW84b1TBxVgkHT/edit?gid=2145585959#gid=2145585959
---

## Jour 1 – Mercredi 28 janvier 2026


**Objectif du jour :** Mettre en place la structure du projet et afficher les annonces depuis la base de données

### Ce que j'ai fait
- Créer la structure du projet avec Slim 
- Configurer la connexion à la base de données avec PDO
- Définir les routes principales : `/`, `/offres`, `/details/{id}`
- Créer le modèle `Annonce` avec la méthode `findAll()` pour récupérer les annonces depuis la table `ads`
- Créer le contrôleur `AnnonceurController` avec la méthode `index()`
- Créer les vues pour l'accueil, la liste des offres et le détail d'une annonce
- Mettre en place un layout commun avec une navigation qui s'adapte selon la page
- Écrire le journal de bord

### Problèmes rencontrés
- Les noms des champs dans le modèle ne correspondaient pas à ceux de la base de données (ex: `start_date` / `end_date`)
- La route `/details/{id}` renvoyait du HTML au lieu du JSON attendu par le JavaScript

### Ce que j'ai fait pour résoudre
- Corriger les noms de variables dans le modèle, le contrôleur et la vue pour qu'ils correspondent aux colonnes de la table `ads`
- Ajouter le header `Content-Type: application/json` sur la route détail

### Tâches prévues pour la prochaine séance
- Créer la page de connexion et d'inscription 
- Implémenter l'inscription et la connexion côté backend 

---

## Jour 2 – Mercredi 4 février 2026

 
**Objectif du jour :** Implémenter l'inscription et la connexion des utilisateurs

### Ce que j'ai fait
- Mettre à jour le planning selon l'avancement réel du jour 1
- Créer le modèle `User` avec les méthodes `insert()` et `findByLogin()` pour interagir avec la table `users`
- Créer le contrôleur `AuthController` avec les méthodes `register()` et `login()`
- Définir les routes : `/auth/login`, `/auth/register`, `/logout`
- Développer le backend de l'inscription : validation des champs, hashage du mot de passe avec `password_hash()`, insertion dans `users`
- Développer le backend de la connexion : vérification du mot de passe avec `password_verify()`, démarrage de la session
- Mettre en place la gestion des sessions (démarrage, stockage de l'utilisateur, destruction à la déconnexion)
- Développer la route `/offres` : récupérer les annonces depuis `ads` et les passer à la vue
- Afficher la liste des offres dynamiquement dans la vue
- Écrire le journal de bord

### Problèmes rencontrés
- Le formulaire d'inscription acceptait des champs vides ou un email mal formaté sans afficher d'erreur

### Ce que j'ai fait pour résoudre
- Ajouter des contrôles sur chaque champ : longueur minimale, format email, correspondance des deux mots de passe
- Afficher un message d'erreur clair sous chaque champ en cas de saisie incorrecte

### Tâches prévues pour la prochaine séance
- Créer le dashboard annonceur
- Commencer le CRUD des annonce

---

## Jour 3 – Mercredi 11 février 2026


**Objectif du jour :** Créer l'espace annonceur et permettre la gestion des annonces via des modales JavaScript

### Ce que j'ai fait
- Créer la vue dashboard annonceur (`/annonceur/dashboard`) qui liste les annonces de l'utilisateur connecté
- Ajouter la méthode `findAnnonceByUserId()` dans le modèle `Annonce` pour filtrer les annonces par `user_id`
- Ajouter la méthode `nombreStage()` pour compter le total des annonces dans `ads`
- Créer la méthode `verifMedia()` pour valider et uploader les PDF (max 1 Mo, extension `.pdf` uniquement), le chemin étant stocké dans `media_path`
- Créer la méthode `updateAnnonce()` dans le modèle pour faire le `UPDATE` en base
- Développer les méthodes `dashboard()` et `updateAnnonce()` dans `AnnonceurController`
- Créer la vue `annonceur/detail.php` avec le statut de chaque annonce (Active si `end_date` >= aujourd'hui, Expirée sinon)
- Définir les routes du groupe `/annonceur` : `/dashboard`, `/details/{id}`, `/create`, `/edit/{id}`, `/delete/{id}`
- Préparer la structure des routes pour le groupe `/chercheur`
- Développer `annonceur.js` : affichage des détails et du formulaire de modification dans des modales via `fetch()`
- Gérer l'ouverture et la fermeture des modales avec des événements JavaScript
- Filtrer et nettoyer les données du formulaire avant envoi au backend
- Écrire le journal de bord

### Problèmes rencontrés
- L'upload refusait certains fichiers valides à cause d'un contrôle trop strict sur le type MIME
- Le média existant n'apparaissait pas dans le formulaire de modification si l'annonce en avait un


### Ce que j'ai fait pour résoudre
- Vérifier à la fois l'extension et le type MIME dans `verifMedia()` pour éviter les faux positifs
- Afficher le lien vers le fichier actuel dans la modale si `media_path` n'est pas vide, sinon afficher "Aucun média"
- Ajouter un événement `submit` sur le formulaire qui ferme la modale et rafraîchit la liste après l'envoi

### Tâches prévues pour la prochaine séance
- Finaliser la création et la suppression d'annonces 
- Corriger les erreurs restantes sur la modification
- Commencer la page administrateur

---

## Jour 4 – Mercredi 18 février 2026


**Objectif du jour :** Finaliser le CRUD des annonces et corriger les erreurs de modification

### Ce que j'ai fait
- Finaliser la création d'annonce côté backend (route `/annonceur/create`) avec insertion dans `ads` 
- Corriger la méthode `updateAnnonce()` pour que le `UPDATE` SQL fonctionne correctement
- Corriger le mapping des champs : le formulaire envoyait `date_debut` et `date_fin`, mais la base attend `start_date` et `end_date`
- Ajouter des messages de retour clairs après chaque opération (création, modification, suppression)
- Implémenter la suppression d'annonce (route `/annonceur/delete/{id}`) avec vérification que l'annonce appartient bien à l'utilisateur connecté
- Mettre à jour le planning effectif pour refléter le temps réellement passé sur le CRUD
- Écrire le journal de bord

### Problèmes rencontrés
- Erreur SQL `Integrity constraint violation` : le champ `start_date` était envoyé `NULL` à cause du mauvais nom de champ dans le formulaire
- Le temps passé à corriger le CRUD a été plus long que prévu, ce qui a décalé les tâches suivantes

### Ce que j'ai fait pour résoudre
- Renommer les champs dans le formulaire HTML pour qu'ils correspondent exactement aux colonnes de la table `ads`
- Ajouter une vérification avant le `UPDATE` pour s'assurer qu'aucun champ obligatoire n'est `NULL`

### Bilan
Le CRUD des annonces fonctionne complètement. Par contre, je n'ai pas pu commencer la page administrateurni la recherche d'annonces comme prévu. Ces deux tâches sont reportées au jour 5. J'ai mis à jour le planning effectif en conséquence.

### Tâches prévues pour la prochaine séance
- Créer la page administrateur 
- Implémenter la recherche d'annonces
- Commencer le CSS

## Jour 5 – Mercredi 3 mars 2026

**Objectif du jour :** Créer la page administrateur et implémenter la recherche d'annonces

### Ce que j'ai fait
- Implémenter la recherche d'annonces par compétences via une requête SQL avec `LIKE` sur la colonne `required_skills`
- Développer la route `/search/{params}` qui retourne les résultats en JSON
- Ajoutde  l'événement `input` sur la barre de recherche, appel `fetch()` vers la route de recherche avec le params ( la value de l'input ) , mise à jour dynamique de la liste des annonces
- Gérer l'affichage du nombre d'offres trouvées mis à jour à chaque frappe
- Afficher un message si aucune annonce ne correspond au mot-clé saisi
- Reloader la page via `location.reload()` quand la barre de recherche est vidée
- Écrire le journal de bord

### Problèmes rencontrés
- La première heure a été consacrée à un récapitulatif des notes et remarques, ( pas un problème en soit mais j'ai pas pu commencer la page administrateur ) 
- Conflit entre les annonces générées par PHP au chargement de la page et celles générées dynamiquement en Js ( quand la searchbar était vidée, le compteur affichait un nombre incorrect car le JS prenait le dessus sur l'affichage du nombre de annnonces trouvées PHP )
- Des doublons apparaissaient dans les résultats de recherche à cause des jointures avec `ad_keywords`
- Le message "aucune annonce trouvée" ne s'affichait pas à cause d'un conflit entre le style inline `display: none` et la classe CSS `.active-message`

### Ce que j'ai fait pour résoudre
- Résoudre le conflit PHP, JS en mettant un `location.reload()` lorsque la searchbar est vide, ce qui laisse le PHP reprendre l'affichage des 
- Ajouter `DISTINCT` dans la requête SQL pour éliminer les doublons

### Bilan
La fonctionnalité de recherche fonctionne mais a pris plus de temps que prévu en raison des conflits entre le rendu PHP et la génération dynamique du JS. La page administrateur n'a pas pu être commencée. Elle est reportée au jour 6.

### Tâches prévues pour la prochaine séance
- Créer la page administrateur
- Commencer le CSS



