-- Création de la base de données
CREATE DATABASE IF NOT EXISTS tp_codeigniter4_notes;
USE tp_codeigniter4_notes;

-- 1. Table des utilisateurs (pour le Login)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- À hasher en PHP
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table des étudiants
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    student_number VARCHAR(20) UNIQUE NOT NULL
);

-- 3. Table des matières
-- 'is_optional' permet de gérer la règle de la meilleure note parmi les options
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    semester ENUM('S3', 'S4') NOT NULL,
    pathway ENUM('common', 'dev', 'bddres', 'web') DEFAULT 'common',
    is_optional BOOLEAN DEFAULT FALSE
);

-- 4. Table des notes
-- On permet plusieurs saisies pour la même matière (règle de la note MAX)
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

---


