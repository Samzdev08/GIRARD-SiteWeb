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
- Mélange du HTML et du PHP
- Incohérences dans les noms des champs
- Route détail retournant du JSON

##  Solutions
- Réorganisation en MVC
- Harmonisation des noms de variables
- Préparation d’une vue HTML pour le détail


# Journal de bord – Jour 2

### Objectif

Avancer sur le backend de l’application en implémentant l’inscription, la connexion des utilisateurs et la page de liste des offres, tout en respectant le planning prévu.

---

### Choses faites

- Ajustement du planning prévisionnel
- Ajustement de la liste des tâches en fonction de l’avancement
- Mise en place du backend de la page d’inscription
- Mise en place du backend de la page de connexion
- Gestion de l’authentification des utilisateurs
- Mise en place des sessions utilisateur
- Création de la logique backend pour la page de liste des offres
- Récupération des annonces depuis la base de données
- Affichage dynamique de la liste des offres dans la vue
- Liaison correcte entre routes, contrôleurs et modèles

---

### Problèmes rencontrés

- Difficulté à gérer correctement les sessions utilisateur
- Problèmes lors de la validation des données du formulaire d’inscription
- Confusion entre utilisateurs connectés et non connectés
- Requêtes SQL initialement incomplètes pour la liste des offres

---

### Solutions

- Mise en place d’une logique claire pour la gestion des sessions
- Ajout de contrôles sur les champs du formulaire d’inscription et de connexion
- Séparation plus stricte des responsabilités entre contrôleur et vue
- Correction et optimisation des requêtes SQL pour récupérer les offres


