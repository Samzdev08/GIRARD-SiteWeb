# GIRARD-SiteWeb

# Journal de bord – Jour 1

##  Objectif
Afficher les offres d’emploi depuis une base de données avec le framework Slim.

##  Choses faites
- Mise en place des routes principales (`/`, `/offres`, `/details/{id}`)
- Création du modèle `Annonce` pour récupérer les annonces
- Création du contrôleur `AnnonceurController`
- Affichage des offres et des compétences dans les vues
- Utilisation d’un layout commun avec navigation dynamique

##  Problèmes rencontrés
- Incohérences dans les noms des champs
- Route détail retournant pas du JSON

##  Solutions
- Harmonisation des noms de variables


# Journal de bord – Jour 2

### Objectif

Avancer sur le backend de l’application en implémentant l’inscription, la connexion des utilisateurs et la page de liste des offres, tout en respectant le planning prévu.

---

### Choses faites

- Ajustement du planning prévisionnel
- Ajustement de la liste des tâches en fonction de l’avancement
- Uilisation du modèle `User` pour insérer les utilisateurs et vérifier si leur login correspond
- Utilisation du contrôleur `AuthController`
- Mise en place des routes d'auth (`/auth/login`, `/auth/register`, `/logout`)
- Mise en place du backend de la route `/auth/register`  ( la page d’inscriptionn )
- Mise en place du backend de la route `/auth/login`  ( la page de connexion )
- Mise en place des sessions utilisateur
- Création de la logique backend pour la route `/offres`  ( la page de liste des annonces )
- Affichage dynamique de la liste des offres dans la vue


---

### Problèmes rencontrés

- Problèmes lors de la validation des données du formulaire d’inscription

---

### Solutions

- Ajout de contrôles sur les champs du formulaire d’inscription et de connexion


# Journal de bord – Jour 3

## Objectif
Développer l'espace annonceur avec la gestion complète des annonces (affichage, modification, suppression) et mettre en place l'interaction frontend/backend via JavaScript.

## Choses faites
* Création de la page **dashboard annonceur** (`/annonceur/dashboard`)
* Mise en place de la méthode `findAnnonceByUserId()` dans le modèle `Annonce` pour récupérer les annonces d'un utilisateur spécifique
* Ajout de la méthode `nombreStage()` pour compter le nombre total d'annonces
* Implémentation de la méthode `verifMedia()` pour valider et uploader des fichiers PDF (limite de 1 Mo)
* Création de la méthode `updateAnnonce()` dans le modèle pour mettre à jour une annonce en base de données
* Développement du contrôleur `AnnonceurController` avec les méthodes :
  * `dashboard()` : affichage de toutes les annonces de l'utilisateur connecté
  * `updateAnnonce()` : traitement du formulaire de modification avec upload de média
* Création de la vue `annonceur/detail.php` affichant la liste des annonces avec leur statut (Active/Expirée)
* Mise en place des routes du groupe `/annonceur` :
  * `/dashboard`, `/details/{id}`, `/create`, `/edit/{id}`, `/delete/{id}`
* Mise en place des routes du groupe `/chercheur` (structure préparée)
* Développement du fichier JavaScript `annonceur.js` pour gérer :
  * L'affichage des détails d'une annonce dans une modale
  * L'affichage du formulaire de modification dans une modale
  * Les appels fetch vers `/details/{id}` pour récupérer les données en JSON
* Création du système de modale pour afficher et modifier les annonces sans rechargement de page
* Gestion du filtrage et de la sanitisation des données du formulaire de modification

## Problèmes rencontrés
* Gestion de l'upload de fichiers PDF avec vérification de taille et d'extension
* Affichage dynamique du média existant dans le formulaire de modification
* Fermeture de la modale après soumission du formulaire

## Solutions
* Ajout de contrôles stricts sur la taille (max 1 Mo) et l'extension (uniquement PDF) des fichiers uploadés
* Création d'une fonction `verifMedia()` pour la validation des fichiers
* Affichage conditionnel du lien vers le média actuel si présent, sinon message "Aucun média"
* Utilisation d'événements JavaScript pour gérer l'ouverture/fermeture des modales




## Journal de bord – Jour 4

### Objectif

Finaliser le CRUD des annonces, corriger les erreurs rencontrées lors de la modification, mettre en place la page administrateur et implémenter la recherche d’annonces et ajustement du planning entier.

---

### Choses faites

- Finalisation complète du CRUD des annonces (création, modification, suppression et affichage)
- Correction de la méthode `updateAnnonce` pour assurer la bonne mise à jour des données en base
- Amélioration de la gestion des messages utilisateur (succès et erreur) lors des opérations
- Correction du mapping entre les champs du formulaire (`date_debut`, `date_fin`) et la base de données (`start_date`, `end_date`)
- Ajuster le planning pour qu'il corresponde à mon avancement
---

### Problèmes rencontrés

- Erreur SQL (`Integrity constraint violation`) due à un champ `start_date` envoyé `NULL` lors de la modification d’une annonce
- Incohérence entre les noms des champs du formulaire et ceux attendus par la base de données
- Temps de développement plus long que prévu pour stabiliser le CRUD

---

### Solutions

- Correction du mapping des dates pour garantir l’envoi de valeurs valides à la base
---

### Bilan

Le CRUD d’une annonce est désormais entièrement fonctionnel, mais sa mise en place a demandé plus de temps que prévu en raison des ajustements nécessaires et des corrections d’erreurs ce qui fait que je n'ai pu faire la page admin et implémenter la recherche d'annonce


