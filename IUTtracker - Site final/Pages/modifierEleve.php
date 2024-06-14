<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données requises sont présentes
    if (isset($_POST['id'], $_POST['prenom'], $_POST['nom'], $_POST['mail'], $_POST['télé'], $_POST['classe'], $_POST['login'], $_POST['mdp'])) {
        // Récupérer les données du formulaire
        $id = $_POST['id'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        $telephone = $_POST['télé'];
        $classe = $_POST['classe'];
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
            $sql = "UPDATE Etudiant 
                    SET nom = :nom, prénom = :prenom, mail_univ = :mail, téléphone = :telephone, Id_Classe = :classe, login_etudiant = :login, mdp_etudiant = :mdp 
                    WHERE Id_Etudiant = :id";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':classe', $classe);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':mdp', $mdp);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Rediriger vers la page VuEleve.php après la mise à jour
            header("Location: VuEleve.php");
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
