<?php
// Vérifier si l'ID de la ressource est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'ID de la ressource à supprimer
    $id = $_GET['id'];

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
        
        // Requête SQL pour supprimer la ressource
        $sql_delete = "DELETE FROM Resource WHERE Id_resource = ?";
        
        // Préparation de la requête
        $stmt_delete = $pdo->prepare($sql_delete);
        
        // Exécution de la requête avec l'ID bindé
        $stmt_delete->execute([$id]);

        // Redirection vers la page Res.php après la suppression
        header("Location: Res.php");
        exit();

    } catch (PDOException $e) {
        // En cas d'erreur de connexion ou d'exécution de requête
        echo "Erreur : " . $e->getMessage();
        die();
    }
} else {
    // Redirection vers Res.php si l'ID n'est pas spécifié
    header("Location: Res.php");
    exit();
}
?>
