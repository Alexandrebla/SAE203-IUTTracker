<?php
// Vérifier si les données du formulaire sont soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs nécessaires sont présents
    if (isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['ue'])) {
        // Récupérer les données du formulaire
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $ue = $_POST['ue'];

        // Informations de connexion à la base de données
        $serveur = "mysql-hamonbrouillard.alwaysdata.net";
        $utilisateur = "362372";
        $motdepasse = "tructruc123*";
        $basededonnees = "hamonbrouillard_iuttracker";

        try {
            // Création de l'objet PDO
            $pdo = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
            
            // Configuration des attributs de PDO pour gérer les erreurs et les exceptions
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Requête SQL pour mettre à jour la ressource
            $sql = "UPDATE Resource SET Nom = ?, Id_UE = ? WHERE Id_resource = ?";
            
            // Préparation de la requête
            $stmt = $pdo->prepare($sql);
            
            // Exécution de la requête avec les valeurs bindées
            $stmt->execute([$nom, $ue, $id]);

            // Redirection vers la page des ressources après mise à jour
            header("Location: Res.php");
            exit();
            
        } catch (PDOException $e) {
            // En cas d'erreur de connexion ou d'exécution de requête
            echo "Erreur : " . $e->getMessage();
            die();
        }
    } else {
        echo "Tous les champs du formulaire doivent être renseignés.";
        exit();
    }
} else {
    echo "Accès non autorisé à cette page.";
    exit();
}
?>
