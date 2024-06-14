<?php
// Vérifier si des données ont été soumises via le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données nécessaires sont présentes
    if (isset($_POST['ID']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['mail']) && isset($_POST['login']) && isset($_POST['mdp'])) {
        // Récupérer les données soumises depuis le formulaire
        $id_professeur = $_POST['ID'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];

        // Paramètres de connexion à la base de données
        $serveur = "mysql-hamonbrouillard.alwaysdata.net";
        $utilisateur = "362372";
        $motdepasse = "tructruc123*";
        $basededonnees = "hamonbrouillard_iuttracker";

        try {
            // Connexion à la base de données avec PDO
            $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour mettre à jour les données du professeur dans la base de données
            $requete = "UPDATE Professeur SET prénom = :prenom, nom = :nom, mail_univ = :mail, login_prof = :login, mdp_prof = :mdp WHERE Id_Professeur = :id";

            // Préparation de la requête
            $statement = $connexion->prepare($requete);

            // Liaison des paramètres
            $statement->bindParam(':id', $id_professeur);
            $statement->bindParam(':prenom', $prenom);
            $statement->bindParam(':nom', $nom);
            $statement->bindParam(':mail', $mail);
            $statement->bindParam(':login', $login);
            $statement->bindParam(':mdp', $mdp);

            // Exécution de la requête
            $statement->execute();

            // Redirection vers VuProf.php après la mise à jour
            header('Location: VuProf.php');
            exit();
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Redirection vers la page modifP.php si des données sont manquantes
        header('Location: modifP.php');
        exit();
    }
} else {
    // Redirection vers la page modifP.php si la requête n'est pas de type POST
    header('Location: modifP.php');
    exit();
}
?>
