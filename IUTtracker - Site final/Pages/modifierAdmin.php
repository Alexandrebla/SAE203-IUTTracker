<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données requises sont présentes
    if (isset($_POST['id_admin'], $_POST['prenom'], $_POST['nom'], $_POST['mail'], $_POST['login'], $_POST['mdp'])) {
        // Récupérer les données du formulaire
        $id_admin = $_POST['id_admin'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];
        
        // Database connection details
        $serveur = "mysql-hamonbrouillard.alwaysdata.net";
        $utilisateur = "362372";
        $motdepasse = "tructruc123*";
        $basededonnees = "hamonbrouillard_iuttracker";

        try {
            // Connecter à la base de données avec PDO
            $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparer et exécuter la requête SQL de mise à jour
            $sql = "UPDATE Administrateur 
                    SET Nom_admin = :nom, prénom_admin = :prenom, mail_univ = :mail, login_admin = :login, mdp_admin = :mdp 
                    WHERE Id_admin = :id_admin";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':mdp', $mdp);
            $stmt->bindParam(':id_admin', $id_admin);
            $stmt->execute();

            // Rediriger vers la page VuAdmin.php après la mise à jour
            header("Location: VuAdmin.php");
            exit();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }

        // Fermer la connexion
        $connexion = null;
    } else {
        // Si des données requises sont manquantes, afficher un message d'erreur
        echo "Toutes les données requises n'ont pas été fournies.";
    }
}
?>
