<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $id = $_POST['ID'];
    $nom = $_POST['nom'];
    $id_ue = $_POST['ue']; // C'est l'ID de l'UE sélectionnée dans le menu déroulant

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
        
        // Requête SQL pour insérer une nouvelle ressource
        $sql_insert = "INSERT INTO Resource (Id_resource, Nom, Id_UE) VALUES (?, ?, ?)";
        
        // Préparation de la requête
        $stmt_insert = $pdo->prepare($sql_insert);
        
        // Exécution de la requête avec les valeurs bindées
        $stmt_insert->execute([$id, $nom, $id_ue]);

        // Redirection vers la page Res.php après l'ajout
        header("Location: Res.php");
        exit();

    } catch (PDOException $e) {
        // En cas d'erreur de connexion ou d'exécution de requête
        echo "Erreur : " . $e->getMessage();
        die();
    }
} else {
    // Redirection vers FormR.php si le formulaire n'a pas été soumis directement
    header("Location: FormR.php");
    exit();
}
?>
