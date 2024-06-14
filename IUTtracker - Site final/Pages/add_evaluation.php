<?php
// Informations de connexion à la base de données
$serveur = "mysql-hamonbrouillard.alwaysdata.net"; // Adresse du serveur de base de données
$utilisateur = "362372"; // Nom d'utilisateur de la base de données
$motdepasse = "tructruc123*"; // Mot de passe de la base de données
$basededonnees = "hamonbrouillard_iuttracker"; // Nom de la base de données

// Récupérer les données du formulaire
$idControle = $_POST['id-controle']; // Ajout de cette ligne pour récupérer l'ID du contrôle
$nomControle = $_POST['nom-controle'];
$date = $_POST['date'];
$duree = $_POST['duree'];
$type = $_POST['type'];
$coeff = $_POST['coeff'];

try {
    // Connexion à la base de données avec PDO
    $bdd = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    // Configuration pour afficher les erreurs
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête d'insertion des données dans la table Contrôle
    $query = $bdd->prepare("INSERT INTO Contrôle (Id_Contrôle, nom_controle, date, durée, type, coeff) VALUES (?, ?, ?, ?, ?, ?)");
    $query->execute([$idControle, $nomControle, $date, $duree, $type, $coeff]);

    // Redirection vers la page principale après l'insertion
    header("Location: Evaluation.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}
?>
