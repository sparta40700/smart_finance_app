<?php
// Vérifier si l'utilisateur est connecté
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer le type d'abonnement choisi
    $type_abonnement = $_POST['type_abonnement'];

    // Valider le type d'abonnement (vous pouvez ajouter d'autres validations selon vos besoins)
    if ($type_abonnement !== "mensuel" && $type_abonnement !== "annuel") {
        // Rediriger l'utilisateur avec un message d'erreur en cas de type d'abonnement invalide
        header("Location: inscription_abonnement.php?error=invalidsubscriptiontype");
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

    // Enregistrement de l'abonnement dans la base de données
    $id_utilisateur = $_SESSION['id_utilisateur'];
    $date_debut = date("Y-m-d");
    $date_fin = ($type_abonnement === "mensuel") ? date("Y-m-d", strtotime("+1 month")) : date("Y-m-d", strtotime("+1 year"));

    $sql = "INSERT INTO abonnements (id_utilisateur, type_abonnement, date_debut, date_fin) 
            VALUES ('$id_utilisateur', '$type_abonnement', '$date_debut', '$date_fin')";

    if ($conn->query($sql) === TRUE) {
        // Rediriger l'utilisateur avec un message de succès si l'abonnement a été enregistré avec succès
        header("Location: espace_utilisateur.php?success=subscriptioncreated");
        exit();
    } else {
        // Rediriger l'utilisateur avec un message d'erreur en cas d'échec de l'enregistrement de l'abonnement
        header("Location: inscription_abonnement.php?error=subscriptionfailed");
        exit();
    }

    $conn->close();
}
