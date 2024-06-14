<?php
session_start(); // Start the session
error_reporting(E_ALL); ini_set('display_errors', 1);

// Database connection details
$serveur = "mysql-hamonbrouillard.alwaysdata.net";
$utilisateur = "362372";
$motdepasse = "tructruc123*";
$basededonnees = "hamonbrouillard_iuttracker";

try {
    // Connect to the database with PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get login credentials from the form
    $login_etudiant = $_POST['login_etudiant'];
    $mdp_etudiant = $_POST['mdp_etudiant'];

    // SQL query to verify credentials
    $requete = $connexion->prepare("SELECT * FROM Etudiant WHERE login_etudiant = :login_etudiant AND mdp_etudiant = :mdp_etudiant");
    $requete->bindParam(':login_etudiant', $login_etudiant);
    $requete->bindParam(':mdp_etudiant', $mdp_etudiant);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Check query result
    if ($resultat) {
        // Store user information in session variables
        $_SESSION['id_etudiant'] = $resultat['Id_Etudiant'];
        $_SESSION['prenom'] = $resultat['prénom'];
        $_SESSION['nom'] = $resultat['nom'];
        $_SESSION['mail_univ'] = $resultat['mail_univ'];
        $_SESSION['login_etudiant'] = $resultat['login_etudiant'];

        // Redirect to the student's homepage
        header('Location: Notes.php');
        exit();
    } else {
        // Redirect to an error page if credentials are incorrect
        header('Location: Erreur.php');
        exit();
    }
} catch (PDOException $e) {
    // Display database connection error
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
