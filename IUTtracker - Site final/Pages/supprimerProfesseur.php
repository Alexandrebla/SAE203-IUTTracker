<?php
// Vérifie si un ID de professeur a été passé via l'URL
if(isset($_GET['id'])) {
    // Paramètres de connexion à la base de données
    $serveur = "mysql-hamonbrouillard.alwaysdata.net";
    $utilisateur = "362372";
    $motdepasse = "tructruc123*";
    $basededonnees = "hamonbrouillard_iuttracker";

    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer et exécuter la requête de suppression
        $requete = "DELETE FROM Professeur WHERE Id_Professeur = :id";
        $statement = $connexion->prepare($requete);
        $statement->bindParam(':id', $_GET['id']);
        $statement->execute();

        // Redirection vers VuProf.php après la suppression
        header('Location: VuProf.php');
        exit();
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "ID du professeur non spécifié.";
}
?>
