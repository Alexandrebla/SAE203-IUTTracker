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

// Vérifier si l'ID de l'étudiant est présent dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $student_id = $_GET['id'];

    // Vérifier si le formulaire de modification est soumis
    if (isset($_POST['nouvelle_note'])) {
        // Récupérer la nouvelle note soumise par l'utilisateur
        $nouvelle_note = $_POST['nouvelle_note'];

        // Effectuer la mise à jour de la note de l'étudiant dans la base de données
        // Assurez-vous de modifier la requête SQL en fonction de votre structure de base de données
        $query = $bdd->prepare("UPDATE Notation SET Note = :nouvelle_note WHERE Id_Etudiant = :student_id AND Id_Contrôle = :id");
        $query->bindParam(':nouvelle_note', $nouvelle_note, PDO::PARAM_INT);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $query->bindParam(':id', $id, PDO::PARAM_INT); // Assurez-vous d'avoir $id défini
        $query->execute();

        // Rediriger l'utilisateur vers la page précédente après la modification
        header("Location: Evaluation.php?id=$id");
        exit;
    }
} else {
    // Rediriger l'utilisateur vers une page d'erreur s'il n'y a pas d'ID d'étudiant dans l'URL
    header("Location: erreur.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Note</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Modifier Note de l'Étudiant</h2>
    <form method="post">
        <label for="nouvelle_note">Nouvelle Note:</label>
        <input type="text" id="nouvelle_note" name="nouvelle_note" required>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
