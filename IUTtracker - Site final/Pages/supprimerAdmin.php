<?php
// Vérifier si le formulaire a été soumis et si l'identifiant de l'administrateur à supprimer est présent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_admin'])) {
    // Récupérer l'identifiant de l'administrateur à supprimer
    $id_admin = $_POST['id_admin'];
    
    // Database connection details
    $serveur = "mysql-hamonbrouillard.alwaysdata.net";
    $utilisateur = "362372";
    $motdepasse = "tructruc123*";
    $basededonnees = "hamonbrouillard_iuttracker";

    try {
        // Connecter à la base de données avec PDO
        $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer et exécuter la requête SQL de suppression
        $sql = "DELETE FROM Administrateur WHERE Id_admin = :id_admin";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id_admin', $id_admin, PDO::PARAM_INT);
        $stmt->execute();

        // Rediriger vers la page VuAdmin.php après la suppression
        header("Location: VuAdmin.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }

    // Fermer la connexion
    $connexion = null;
} else {
    // Si l'identifiant de l'administrateur à supprimer n'est pas présent dans la requête, afficher un message d'erreur
    echo "L'identifiant de l'administrateur à supprimer n'a pas été fourni.";
}
?>
