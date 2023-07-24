CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    adresse_email VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    statut_paiement ENUM('Payé', 'Non Payé') NOT NULL
);
