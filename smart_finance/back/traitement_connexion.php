<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assurez-vous que les champs du formulaire ne sont pas vides
    if (!empty($_POST["email_login"]) && !empty($_POST["mot_de_passe_login"])) {
        // Récupérer les données soumises par le formulaire
        $email = $_POST["email_login"];
        $mot_de_passe = $_POST["mot_de_passe_login"];

        // Nettoyer les données pour éviter les problèmes de sécurité (vous pouvez utiliser d'autres méthodes de nettoyage appropriées ici)
        $email = htmlspecialchars($email);
        $mot_de_passe = htmlspecialchars($mot_de_passe);

        // Connexion à la base de données (remplacez les paramètres par ceux de votre base de données)
        $conn = mysqli_connect("nom_d_hote", "nom_d_utilisateur", "mot_de_passe", "nom_de_la_base_de_donnees");

        // Vérifier si la connexion a réussi
        if ($conn) {
            // Vérifier les informations d'identification de l'utilisateur
            $query = "SELECT * FROM utilisateurs WHERE email = '$email' AND mot_de_passe = '$mot_de_passe'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) === 1) {
                // L'utilisateur est connecté avec succès, créer une session pour lui
                session_start();

                // Stocker l'adresse e-mail de l'utilisateur dans la session pour une utilisation ultérieure (par exemple, pour afficher son nom d'utilisateur sur son espace utilisateur personnalisé)
                $_SESSION["email"] = $email;

                // Rediriger l'utilisateur vers son espace utilisateur personnalisé
                header("Location: espace_utilisateur.php");
                exit();
            } else {
                // Informations d'identification invalides
                echo "Adresse e-mail ou mot de passe incorrect. Veuillez réessayer.";
            }

            // Fermer la connexion à la base de données
            mysqli_close($conn);
        } else {
            // Erreur de connexion à la base de données
            echo "Impossible de se connecter à la base de données. Veuillez réessayer plus tard.";
        }
    } else {
        // Des champs sont vides
        echo "Veuillez remplir tous les champs du formulaire de connexion.";
    }
}
