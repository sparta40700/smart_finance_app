<?php
// Dans modifier_profil_traitement.php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Récupérer les données du formulaire
$nom_complet = $_POST['nom_complet'];
$adresse_email = $_POST['adresse_email'];
$nouveau_mot_de_passe = $_POST['mot_de_passe'];
$confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'];

// Valider les données du formulaire (vous pouvez ajouter d'autres validations selon vos besoins)
if (empty($nom_complet) || empty($adresse_email) || empty($nouveau_mot_de_passe) || empty($confirmation_mot_de_passe)) {
    // Rediriger l'utilisateur avec un message d'erreur s'il y a des champs vides
    header("Location: modifier_profil.php?error=emptyfields");
    exit();
}

// Vérifier si les deux mots de passe saisis correspondent
if ($nouveau_mot_de_passe !== $confirmation_mot_de_passe) {
    // Rediriger l'utilisateur avec un message d'erreur si les mots de passe ne correspondent pas
    header("Location: modifier_profil.php?error=passwordsdontmatch");
    exit();
}

// Connexion à la base de données (remplacez les valeurs par celles de votre base de données)
$servername = "localhost";
$username = "nom_utilisateur";
$password = "mot_de_passe";
$dbname = "nom_base_de_donnees";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier si la connexion à la base de données a réussi
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Requête SQL pour mettre à jour les informations du profil dans la base de données
$id_utilisateur = $_SESSION['id_utilisateur'];
$hashed_mot_de_passe = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT); // Hacher le nouveau mot de passe

$sql = "UPDATE utilisateurs SET nom_complet='$nom_complet', adresse_email='$adresse_email', mot_de_passe='$hashed_mot_de_passe' WHERE id_utilisateur=$id_utilisateur";

if ($conn->query($sql) === TRUE) {
    // Rediriger l'utilisateur avec un message de succès si la mise à jour a réussi
    header("Location: espace_utilisateur.php?success=profilupdated");
    exit();
} else {
    // Rediriger l'utilisateur avec un message d'erreur si la mise à jour a échoué
    header("Location: modifier_profil.php?error=updatefailed");
    exit();
}

$conn->close();
