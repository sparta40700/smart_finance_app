<!DOCTYPE html>
<html>

<head>
    <title>Smart Finance - Espace Utilisateur</title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Header -->
    <!-- Header -->
    <header>
        <h1>Smart Finance</h1>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="/Ateliers.html">Ateliers</a></li>
                <li><a href="/Webinaires.html">Webinaires</a></li>
                <li><a href="/Partenaires.html">Partenaires</a></li>
                <li><a href="/contact.html">Contact</a></li>
                <!-- Modifier le chemin vers la page d'inscription/connexion -->
                <li><a href="connexion.php">Inscription/Connexion</a></li>
            </ul>
        </nav>
    </header>


    <!-- Espace Utilisateur Personnalisé -->
    <section id="espace_utilisateur">
        <?php
        // Démarrer la session pour accéder aux données de l'utilisateur connecté
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["email"])) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header("Location: connexion.php");
            exit();
        }

        // Récupérer l'adresse e-mail de l'utilisateur connecté depuis la session
        $email_utilisateur = $_SESSION["email"];

        // Connexion à la base de données (remplacez les paramètres par ceux de votre base de données)
        $conn = mysqli_connect("nom_d_hote", "nom_d_utilisateur", "mot_de_passe", "nom_de_la_base_de_donnees");

        // Vérifier si la connexion a réussi
        if ($conn) {
            // Récupérer les informations de l'utilisateur depuis la base de données
            $query = "SELECT * FROM utilisateurs WHERE email = '$email_utilisateur'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) === 1) {
                $utilisateur = mysqli_fetch_assoc($result);
                // Vous pouvez afficher les informations de l'utilisateur ici, par exemple :
                echo "<h2>Bienvenue, " . $utilisateur["nom"] . " !</h2>";
                echo "<p>Adresse e-mail : " . $utilisateur["email"] . "</p>";

                // Afficher d'autres informations spécifiques à l'utilisateur si nécessaire
                // ...

            } else {
                echo "Erreur : Impossible de récupérer les informations de l'utilisateur.";
            }

            // Fermer la connexion à la base de données
            mysqli_close($conn);
        }
        ?>

        <!-- Lien pour se déconnecter -->
        <a href="deconnexion.php">Se déconnecter</a>
    </section>

    <!-- Pied de page -->
    <!-- Pied de page -->
    <footer>
        <!-- Liens vers les réseaux sociaux -->
        <!-- ... -->

        <!-- Liens vers les mentions légales et politique de confidentialité -->
        <div class="legal-links">
            <a href="#">Mentions légales</a>
            <a href="#">Politique de confidentialité</a>
            <!-- Modifier le chemin vers la page de déconnexion -->
            <a href="deconnexion.php">Se déconnecter</a>
        </div>

        <!-- ... -->
    </footer>

</body>

</html>