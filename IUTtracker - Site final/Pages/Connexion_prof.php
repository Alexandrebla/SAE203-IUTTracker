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
    $login_prof = $_POST['login_prof'];
    $mdp_prof = $_POST['mdp_prof'];

    // SQL query to verify credentials
    $requete = $connexion->prepare("SELECT * FROM Professeur WHERE login_prof = :login_prof AND mdp_prof = :mdp_prof");
    $requete->bindParam(':login_prof', $login_prof);
    $requete->bindParam(':mdp_prof', $mdp_prof);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Check query result
    if ($resultat) {
        // Store user information in session variables
        $_SESSION['id_professeur'] = $resultat['Id_Professeur'];
        $_SESSION['prenom'] = $resultat['prénom'];
        $_SESSION['nom'] = $resultat['nom'];
        $_SESSION['mail_univ'] = $resultat['mail_univ'];
        $_SESSION['login_prof'] = $resultat['login_prof'];

        // Redirect to the professor's homepage
        header('Location: AcceuilProf.php');
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
