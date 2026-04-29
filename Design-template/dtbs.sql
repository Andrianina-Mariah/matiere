-- 1) Creer la base (si elle n'existe pas)
CREATE DATABASE IF NOT EXISTS bibliotheque
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

-- 2) Utiliser la base
USE bibliotheque;

-- 3) Table livres
CREATE TABLE IF NOT EXISTS livres (
  identifiant INT UNSIGNED NOT NULL AUTO_INCREMENT,
  titre VARCHAR(150) NOT NULL,
  auteur VARCHAR(150) NOT NULL,
  ISBN VARCHAR(20) NOT NULL,
  annee_publication INT NOT NULL,
  categorie VARCHAR(90) NOT NULL,
  resume TEXT NULL,
  nom_fichier_couverture VARCHAR(150) NULL,
  statut ENUM('disponible', 'prete') NOT NULL DEFAULT 'disponible',
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  PRIMARY KEY (identifiant),
  UNIQUE KEY uq_livres_isbn (ISBN)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4) Table emprunts
CREATE TABLE IF NOT EXISTS emprunts (
  identifiant INT UNSIGNED NOT NULL AUTO_INCREMENT,
  livre_id INT UNSIGNED NOT NULL,
  nom_emprunteur VARCHAR(150) NOT NULL,
  date_emprunt DATE NOT NULL,
  date_retour DATE NULL,
  PRIMARY KEY (identifiant),
  KEY idx_emprunts_livre (livre_id),
  CONSTRAINT fk_emprunts_livre
    FOREIGN KEY (livre_id) REFERENCES livres(identifiant)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
