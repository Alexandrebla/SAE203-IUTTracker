<?php
// Database connection details
$serveur = "mysql-hamonbrouillard.alwaysdata.net";
$utilisateur = "362372";
$motdepasse = "tructruc123*";
$basededonnees = "hamonbrouillard_iuttracker";

try {
    // Connect to the database with PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $id = $_POST['ID'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];

        // Prepare the SQL query
        $sql = "INSERT INTO Administrateur (Id_admin, prénom_admin, Nom_admin, mail_univ, login_admin, mdp_admin) 
                VALUES (:id, :prenom, :nom, :mail, :login, :mdp)";

        // Prepare statement
        $stmt = $connexion->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':mdp', $mdp);

        // Execute the query
        $stmt->execute();

        // Redirect to the admin view page
        header("Location: VuAdmin.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connexion = null;
?>
