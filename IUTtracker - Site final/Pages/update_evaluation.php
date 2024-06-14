<?php
// Informations de connexion à la base de données
$serveur = "mysql-hamonbrouillard.alwaysdata.net";
$utilisateur = "362372";
$motdepasse = "tructruc123*";
$basededonnees = "hamonbrouillard_iuttracker";

// Connexion à la base de données avec PDO
try {
    $bdd = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $nom_controle = $_POST['nom_controle'];
    $date = $_POST['date'];
    $durée = $_POST['durée'];
    $type = $_POST['type'];
    $coeff = $_POST['coeff'];
    $type_evaluation = $_POST['type_evaluation']; // Ajout de cette ligne pour récupérer le type d'évaluation

    // Préparer et exécuter la requête de mise à jour
    $update_query = $bdd->prepare("UPDATE Contrôle SET nom_controle = :nom_controle, date = :date, durée = :durée, coeff = :coeff, type_evaluation = :type_evaluation WHERE Id_Contrôle = :id");
$update_query->bindParam(':nom_controle', $nom_controle, PDO::PARAM_STR);
$update_query->bindParam(':date', $date, PDO::PARAM_STR);
$update_query->bindParam(':durée', $durée, PDO::PARAM_INT);
$update_query->bindParam(':coeff', $coeff, PDO::PARAM_INT);
$update_query->bindParam(':type_evaluation', $type_evaluation, PDO::PARAM_STR); // Liaison du paramètre type_evaluation
$update_query->bindParam(':id', $id, PDO::PARAM_INT);
$update_query->execute();


    // Redirection vers la page d'évaluation avec l'ID du contrôle
    header("Location: Evaluation.php?id=$id");
    exit();
}
?>
