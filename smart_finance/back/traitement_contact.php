<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assurez-vous que les champs du formulaire ne sont pas vides
    if (!empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["message"])) {
        // Récupérer les données soumises par le formulaire
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        // Nettoyer les données pour éviter les problèmes de sécurité (vous pouvez utiliser d'autres méthodes de nettoyage appropriées ici)
        $nom = htmlspecialchars($nom);
        $email = htmlspecialchars($email);
        $message = htmlspecialchars($message);

        // Vous pouvez ajouter ici d'autres validations ou traitements des données selon vos besoins

        // Par exemple, vous pouvez envoyer l'e-mail à votre adresse de support pour traiter la demande
        $to = "votre_adresse_email@example.com";
        $subject = "Nouveau message de contact de Smart Finance";
        $headers = "From: $email" . "\r\n" .
            "Reply-To: $email" . "\r\n" .
            "X-Mailer: PHP/" . phpversion();

        // Envoyer l'e-mail
        if (mail($to, $subject, $message, $headers)) {
            // Rediriger l'utilisateur avec un message de succès si l'e-mail a été envoyé avec succès
            header("Location: contact.html?success=mailsent");
            exit();
        } else {
            // Rediriger l'utilisateur avec un message d'erreur en cas d'échec de l'envoi de l'e-mail
            header("Location: contact.html?error=mailfailed");
            exit();
        }
    } else {
        // Des champs sont vides
        header("Location: contact.html?error=emptyfields");
        exit();
    }
}
