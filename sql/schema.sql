DROP DATABASE IF EXISTS sfo_db;

-- Création de la base de données
CREATE DATABASE sfo_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE sfo_db;

-- ============================================
-- Table: users
-- Stocke tous les utilisateurs (annonceurs, chercheurs, administrateurs)
-- ============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('annonceur', 'chercheur', 'administrateur') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user_type (user_type),
    INDEX idx_login (login)
) ENGINE=InnoDB;

-- ============================================
-- Table: keywords
-- Stocke les mots-clés disponibles pour les annonces
-- ============================================
CREATE TABLE keywords (
    id INT AUTO_INCREMENT PRIMARY KEY,
    keyword VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_keyword (keyword)
) ENGINE=InnoDB;

-- ============================================
-- Table: ads
-- Stocke les annonces de job
-- ============================================
CREATE TABLE ads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    required_skills TEXT NULL,
    media_path VARCHAR(500) NULL,
    media_type ENUM('pdf', 'image') NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_dates (start_date, end_date),
    INDEX idx_title (title)
) ENGINE=InnoDB;

-- ============================================
-- Table: ad_keywords
-- Table de liaison entre annonces et mots-clés (relation N:M)
-- ============================================
CREATE TABLE ad_keywords (
    ad_id INT NOT NULL,
    keyword_id INT NOT NULL,
    PRIMARY KEY (ad_id, keyword_id),
    FOREIGN KEY (ad_id) REFERENCES ads(id) ON DELETE CASCADE,
    FOREIGN KEY (keyword_id) REFERENCES keywords(id) ON DELETE CASCADE,
    INDEX idx_ad_id (ad_id),
    INDEX idx_keyword_id (keyword_id)
) ENGINE=InnoDB;

-- ============================================
-- Table: wishlist
-- Stocke les annonces favorites des chercheurs
-- ============================================
CREATE TABLE wishlist (
    user_id INT NOT NULL,
    ad_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, ad_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (ad_id) REFERENCES ads(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_ad_id (ad_id)
) ENGINE=InnoDB;

-- ============================================
-- DONNÉES DE TEST
-- ============================================

-- Insertion des utilisateurs par défaut
-- Mot de passe par défaut pour tous: "password123" (à hasher en PHP avec password_hash())
INSERT INTO users (login, password, user_type) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrateur'),
('annonceur1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'annonceur'),
('annonceur2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'annonceur'),
('chercheur1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'chercheur'),
('chercheur2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'chercheur');

-- Insertion des mots-clés par défaut
INSERT INTO keywords (keyword) VALUES
('PHP'),
('JavaScript'),
('MySQL'),
('HTML/CSS'),
('Bootstrap'),
('React'),
('Vue.js'),
('Laravel'),
('Symfony'),
('Node.js'),
('Python'),
('Java'),
('C#'),
('.NET'),
('Git'),
('Docker'),
('Kubernetes'),
('AWS'),
('Azure'),
('DevOps'),
('Frontend'),
('Backend'),
('Full-Stack'),
('Mobile'),
('iOS'),
('Android'),
('UI/UX'),
('Design'),
('Marketing'),
('Vente'),
('Service Client'),
('Comptabilité'),
('RH'),
('Gestion'),
('Logistique'),
('Stage'),
('CDI'),
('CDD'),
('Temps partiel'),
('Temps plein'),
('Remote'),
('Hybride'),
('Genève'),
('Lausanne'),
('Zürich'),
('Débutant'),
('Confirmé'),
('Expert');

-- Insertion d'annonces de test
INSERT INTO ads (user_id, title, description, required_skills, start_date, end_date) VALUES
(2, 'Développeur PHP/MySQL - CDI', 
'Nous recherchons un développeur PHP/MySQL expérimenté pour rejoindre notre équipe. Vous travaillerez sur des projets web innovants et participerez à toutes les phases de développement.', 
'PHP, MySQL, Bootstrap, Git, POO', 
'2026-01-15', '2026-03-15'),

(2, 'Designer UI/UX - Stage', 
'Stage de 6 mois pour un designer UI/UX créatif. Vous travaillerez sur des projets web modernes et collaborerez avec notre équipe de développeurs.', 
'Figma, Adobe XD, UI/UX, Photoshop', 
'2026-01-20', '2026-04-20'),

(3, 'Développeur Full-Stack JavaScript', 
'Rejoignez notre startup innovante! Nous développons une plateforme SaaS moderne et cherchons un développeur passionné.', 
'React, Node.js, MongoDB, API REST, Docker', 
'2026-01-10', '2026-02-28');

-- Liaison annonces-mots clés
INSERT INTO ad_keywords (ad_id, keyword_id) VALUES
-- Annonce 1: PHP, MySQL, Bootstrap, CDI, Genève
(1, 1), (1, 3), (1, 5), (1, 37), (1, 43),
-- Annonce 2: Design, UI/UX, Stage, Genève
(2, 28), (2, 27), (2, 36), (2, 43),
-- Annonce 3: JavaScript, React, Node.js, Full-Stack, Remote
(3, 2), (3, 6), (3, 10), (3, 23), (3, 41);

-- Ajout de quelques wishlists
INSERT INTO wishlist (user_id, ad_id) VALUES
(4, 1),
(4, 3),
(5, 1),
(5, 2);