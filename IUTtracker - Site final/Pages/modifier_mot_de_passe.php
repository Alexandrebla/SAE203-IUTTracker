<?php
session_start(); // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['id_etudiant'])) {
    header('Location: ../index.php');
    exit();
}

// Database connection details
$serveur = "mysql-hamonbrouillard.alwaysdata.net";
$utilisateur = "362372";
$motdepasse = "tructruc123*";
$basededonnees = "hamonbrouillard_iuttracker";

try {
    // Connect to the database with PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the new password from the form
        if (isset($_POST['new-password']) && !empty($_POST['new-password'])) {
            $newPassword = $_POST['new-password'];

            // Get the user's ID from the session
            $id_etudiant = $_SESSION['id_etudiant'];

            // Prepare and execute the update query
            $stmt = $connexion->prepare("UPDATE Etudiant SET mdp_etudiant = :password WHERE id_etudiant = :id");
            if ($stmt->execute(['password' => $newPassword, 'id' => $id_etudiant])) {
                // Redirect the user back to the profile page with a success message
                header('Location: ProfilE.php?success=1');
                exit();
            } else {
                echo "Erreur lors de la mise à jour du mot de passe.";
            }
        } else {
            echo "Le nouveau mot de passe est vide.";
        }
    } else {
        echo "Formulaire non soumis.";
    }
} catch(PDOException $e) {
    // If an error occurs, handle it appropriately (e.g., display an error message)
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    // You might want to redirect the user to an error page here instead of displaying the error message directly
    // header('Location: erreur.php');
    exit();
}
?>
