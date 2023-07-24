<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assurez-vous que les champs du formulaire ne sont pas vides
    if (!empty($_POST["nom_complet"]) && !empty($_POST["adresse_email"]) && !empty($_POST["mot_de_passe"]) && !empty($_POST["confirmer_mot_de_passe"])) {
        // Récupérer les données soumises par le formulaire
        $nom_complet = $_POST["nom_complet"];
        $adresse_email = $_POST["adresse_email"];
        $mot_de_passe = $_POST["mot_de_passe"];
        $confirmer_mot_de_passe = $_POST["confirmer_mot_de_passe"];

        // Nettoyer les données pour éviter les problèmes de sécurité (vous pouvez utiliser d'autres méthodes de nettoyage appropriées ici)
        $nom_complet = htmlspecialchars($nom_complet);
        $adresse_email = htmlspecialchars($adresse_email);

        // Vérifier si les mots de passe correspondent
        if ($mot_de_passe !== $confirmer_mot_de_passe) {
            echo "Les mots de passe ne correspondent pas. Veuillez réessayer.";
            exit();
        }

        // Hacher le mot de passe avec bcrypt
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        // Connexion à la base de données (remplacez les paramètres par ceux de votre base de données)
        $conn = mysqli_connect("nom_d_hote", "nom_d_utilisateur", "mot_de_passe", "nom_de_la_base_de_donnees");

        // Vérifier si la connexion a réussi
        if ($conn) {
            // Vérifier si l'adresse e-mail est déjà enregistrée dans la base de données
            $query = "SELECT * FROM utilisateurs WHERE adresse_email = '$adresse_email'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "Cette adresse e-mail est déjà enregistrée. Veuillez vous connecter ou utiliser une autre adresse e-mail.";
            } else {
                // Insérer les informations d'inscription dans la base de données
                $sql = "INSERT INTO utilisateurs (nom_complet, adresse_email, mot_de_passe) VALUES ('$nom_complet', '$adresse_email', '$mot_de_passe_hash')";

                if (mysqli_query($conn, $sql)) {
                    // Rediriger l'utilisateur vers la page de connexion avec un message de succès
                    header("Location: connexion.php?success=inscription");
                    exit();
                } else {
                    echo "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
                }
            }

            // Fermer la connexion à la base de données
            mysqli_close($conn);
        } else {
            echo "Impossible de se connecter à la base de données. Veuillez réessayer plus tard.";
        }
    } else {
        echo "Veuillez remplir tous les champs du formulaire d'inscription.";
    }
}
