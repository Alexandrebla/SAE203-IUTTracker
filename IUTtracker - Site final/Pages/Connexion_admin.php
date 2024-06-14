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
    $login_admin = $_POST['login_admin'];
    $mdp_admin = $_POST['mdp_admin'];

    // SQL query to verify credentials
    $requete = $connexion->prepare("SELECT * FROM Administrateur WHERE login_admin = :login_admin AND mdp_admin = :mdp_admin");
    $requete->bindParam(':login_admin', $login_admin);
    $requete->bindParam(':mdp_admin', $mdp_admin);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Check query result
    if ($resultat) {
        // Store user information in session variables
        $_SESSION['id_admin'] = $resultat['Id_admin'];
        $_SESSION['prenom_admin'] = $resultat['prénom_admin'];
        $_SESSION['nom_admin'] = $resultat['Nom_admin'];
        $_SESSION['mail_univ'] = $resultat['mail_univ'];
        $_SESSION['login_admin'] = $resultat['login_admin'];

        // Redirect to the administrator's homepage
        header('Location: AcceuilAdmin.php');
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
