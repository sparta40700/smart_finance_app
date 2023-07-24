<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assurez-vous que les champs du formulaire ne sont pas vides
    if (!empty($_POST["adresse_email"]) && !empty($_POST["mot_de_passe_login"])) {
        // Récupérer les données soumises par le formulaire
        $adresse_email = $_POST["adresse_email"];
        $mot_de_passe = $_POST["mot_de_passe_login"];

        // Nettoyer les données pour éviter les problèmes de sécurité (vous pouvez utiliser d'autres méthodes de nettoyage appropriées ici)
        $adresse_email = htmlspecialchars($adresse_email);

        // Connexion à la base de données (remplacez les paramètres par ceux de votre base de données)
        $conn = mysqli_connect("nom_d_hote", "nom_d_utilisateur", "mot_de_passe", "nom_de_la_base_de_donnees");

        // Vérifier si la connexion a réussi
        if ($conn) {
            // Récupérer le mot de passe haché de l'utilisateur depuis la base de données
            $query = "SELECT mot_de_passe FROM utilisateurs WHERE adresse_email = '$adresse_email'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $mot_de_passe_hash = $row["mot_de_passe"];

                // Vérifier le mot de passe haché avec la fonction password_verify
                if (password_verify($mot_de_passe, $mot_de_passe_hash)) {
                    // L'utilisateur est connecté avec succès, créer une session pour lui
                    session_start();

                    // Stocker l'adresse e-mail de l'utilisateur dans la session pour une utilisation ultérieure (par exemple, pour afficher son nom d'utilisateur sur son espace utilisateur personnalisé)
                    $_SESSION["adresse_email"] = $adresse_email;

                    // Rediriger l'utilisateur vers son espace utilisateur personnalisé
                    header("Location: espace_utilisateur.php");
                    exit();
                } else {
                    // Informations d'identification invalides
                    echo "Adresse e-mail ou mot de passe incorrect. Veuillez réessayer.";
                }
            } else {
                // Adresse e-mail non trouvée dans la base de données
                echo "Adresse e-mail non enregistrée. Veuillez vous inscrire d'abord.";
            }

            // Fermer la connexion à la base de données
            mysqli_close($conn);
        } else {
            echo "Impossible de se connecter à la base de données. Veuillez réessayer plus tard.";
        }
    } else {
        echo "Veuillez remplir tous les champs du formulaire de connexion.";
    }
}
