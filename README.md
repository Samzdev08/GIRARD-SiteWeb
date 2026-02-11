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
- Réorganisation en MVC
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





