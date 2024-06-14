<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si l'ID de l'étudiant est présent dans la requête
    if (isset($_POST['id'])) {
        // Récupérer l'ID de l'étudiant
        $id = $_POST['id'];
        
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
            $sql = "DELETE FROM Etudiant WHERE Id_Etudiant = :id";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Rediriger vers la page VuEleve.php après la suppression
            header("Location: VuEleve.php");
            exit();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }

        // Fermer la connexion
        $connexion = null;
    } else {
        // Si l'ID de l'étudiant est manquant, afficher un message d'erreur
        echo "L'ID de l'étudiant est manquant.";
    }
}
?>
