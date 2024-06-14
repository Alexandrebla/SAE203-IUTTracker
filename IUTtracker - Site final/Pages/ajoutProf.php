<?php
// Récupérer les données du formulaire
$id = $_POST['ID'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
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

    // Requête d'insertion
    $requete = "INSERT INTO Professeur (Id_Professeur, nom, prénom, mail_univ, login_prof, mdp_prof) VALUES (:id, :nom, :prenom, :mail, :login, :mdp)";
    
    // Préparation de la requête
    $statement = $connexion->prepare($requete);
    
    // Liaison des paramètres
    $statement->bindParam(':id', $id);
    $statement->bindParam(':nom', $nom);
    $statement->bindParam(':prenom', $prenom);
    $statement->bindParam(':mail', $mail);
    $statement->bindParam(':login', $login);
    $statement->bindParam(':mdp', $mdp);
    
    // Exécution de la requête
    $statement->execute();
    
    // Redirection vers VuProf.php après l'ajout
    header('Location: VuProf.php');
    exit(); // Assurez-vous d'arrêter l'exécution du script après la redirection
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
