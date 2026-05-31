DROP DATABASE IF EXISTS voyagevista;

CREATE DATABASE voyagevista
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE voyagevista;

CREATE TABLE roles (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    nom_role VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE utilisateurs (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(50) DEFAULT 'actif',
    id_role INT NOT NULL,
    FOREIGN KEY (id_role) REFERENCES roles(id_role)
);

CREATE TABLE destinations (
    id_destination INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    categorie VARCHAR(100),
    budget_moyen DECIMAL(10,2)
);

CREATE TABLE hebergements (
    id_hebergement INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    adresse VARCHAR(255),
    prix_nuit DECIMAL(10,2) NOT NULL,
    capacite INT NOT NULL,
    image VARCHAR(255),
    statut VARCHAR(50) DEFAULT 'disponible',
    id_destination INT NOT NULL,
    id_prestataire INT NOT NULL,
    FOREIGN KEY (id_destination) REFERENCES destinations(id_destination),
    FOREIGN KEY (id_prestataire) REFERENCES utilisateurs(id_user)
);

CREATE TABLE disponibilites (
    id_disponibilite INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    places_restantes INT NOT NULL,
    id_hebergement INT NOT NULL,
    FOREIGN KEY (id_hebergement) REFERENCES hebergements(id_hebergement)
);

CREATE TABLE transports (
    id_transport INT AUTO_INCREMENT PRIMARY KEY,
    type_transport VARCHAR(50) NOT NULL,
    ville_depart VARCHAR(100) NOT NULL,
    ville_arrivee VARCHAR(100) NOT NULL,
    date_depart DATETIME NOT NULL,
    date_arrivee DATETIME NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    places_disponibles INT NOT NULL,
    id_destination INT NOT NULL,
    id_prestataire INT NOT NULL,
    FOREIGN KEY (id_destination) REFERENCES destinations(id_destination),
    FOREIGN KEY (id_prestataire) REFERENCES utilisateurs(id_user)
);

CREATE TABLE activites (
    id_activite INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    capacite INT NOT NULL,
    date_activite DATETIME NOT NULL,
    image VARCHAR(255),
    id_destination INT NOT NULL,
    id_prestataire INT NOT NULL,
    FOREIGN KEY (id_destination) REFERENCES destinations(id_destination),
    FOREIGN KEY (id_prestataire) REFERENCES utilisateurs(id_user)
);

CREATE TABLE sejours (
    id_sejour INT AUTO_INCREMENT PRIMARY KEY,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    prix_total DECIMAL(10,2) DEFAULT 0,
    statut VARCHAR(50) DEFAULT 'brouillon',
    id_user INT NOT NULL,
    id_destination INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES utilisateurs(id_user),
    FOREIGN KEY (id_destination) REFERENCES destinations(id_destination)
);

CREATE TABLE sejour_transport (
    id_sejour INT,
    id_transport INT,
    PRIMARY KEY (id_sejour, id_transport),
    FOREIGN KEY (id_sejour) REFERENCES sejours(id_sejour),
    FOREIGN KEY (id_transport) REFERENCES transports(id_transport)
);

CREATE TABLE sejour_activite (
    id_sejour INT,
    id_activite INT,
    PRIMARY KEY (id_sejour, id_activite),
    FOREIGN KEY (id_sejour) REFERENCES sejours(id_sejour),
    FOREIGN KEY (id_activite) REFERENCES activites(id_activite)
);

CREATE TABLE sejour_hebergement (
    id_sejour INT,
    id_hebergement INT,
    date_arrivee DATE NOT NULL,
    date_depart DATE NOT NULL,
    PRIMARY KEY (id_sejour, id_hebergement),
    FOREIGN KEY (id_sejour) REFERENCES sejours(id_sejour),
    FOREIGN KEY (id_hebergement) REFERENCES hebergements(id_hebergement)
);

CREATE TABLE reservations (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    montant_total DECIMAL(10,2) NOT NULL,
    statut VARCHAR(50) DEFAULT 'en_attente',
    id_sejour INT UNIQUE,
    FOREIGN KEY (id_sejour) REFERENCES sejours(id_sejour)
);

CREATE TABLE paiements (
    id_paiement INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL,
    date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    mode_paiement VARCHAR(50),
    statut VARCHAR(50) DEFAULT 'valide',
    id_reservation INT UNIQUE,
    FOREIGN KEY (id_reservation) REFERENCES reservations(id_reservation)
);

CREATE TABLE notifications (
    id_notification INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lu BOOLEAN DEFAULT FALSE,
    id_user INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES utilisateurs(id_user)
);

CREATE TABLE avis (
    id_avis INT AUTO_INCREMENT PRIMARY KEY,
    note INT NOT NULL CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_avis TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_user INT NOT NULL,
    id_destination INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES utilisateurs(id_user),
    FOREIGN KEY (id_destination) REFERENCES destinations(id_destination)
);

INSERT INTO roles (nom_role)
VALUES
('Voyageur'),
('Prestataire'),
('Moderateur'),
('Administrateur');
