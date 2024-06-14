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

// Récupérer l'ID du contrôle à partir de l'URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
$evaluationData = null;

if ($id) {
    // Préparer et exécuter la requête pour récupérer les données de l'évaluation
    $query = $bdd->prepare("SELECT * FROM Contrôle WHERE Id_Contrôle = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $evaluationData = $query->fetch(PDO::FETCH_ASSOC);

    // Requête pour récupérer les informations des étudiants pour cette évaluation
    $sql_students = "SELECT Etudiant.Id_Etudiant, Etudiant.nom, Etudiant.prénom, IFNULL(Notation.Note, 'non noté') AS Note 
                     FROM Etudiant 
                     LEFT JOIN Notation ON Etudiant.Id_Etudiant = Notation.Id_Etudiant AND Notation.Id_Contrôle = :id";
    $stmt_students = $bdd->prepare($sql_students);
    $stmt_students->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_students->execute();
    $students_data = $stmt_students->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "ID de l'évaluation non spécifié.";
    exit;
}

// Traitement du formulaire de mise à jour des notes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_controle'])) {
    $id_controle = $_POST['id_controle'];
    $notes = $_POST['note'];

    // Préparation de la requête SQL pour mettre à jour les notes dans la table Notation
    $sql_update_note = "UPDATE Notation SET Note = :note WHERE Id_Contrôle = :id_controle AND Id_Etudiant = :id_etudiant";
    $stmt_update_note = $bdd->prepare($sql_update_note);

    // Préparation de la requête SQL pour insérer les nouvelles notes dans Notation
    $sql_insert_note = "INSERT INTO Notation (Note, Id_Contrôle, Id_Etudiant, Id_Professeur, Id_resource)
                        VALUES (:note, :id_controle, :id_etudiant, :id_professeur, :id_resource)
                        ON DUPLICATE KEY UPDATE Note = VALUES(Note)";
    $stmt_insert_note = $bdd->prepare($sql_insert_note);

    foreach ($notes as $id_etudiant => $note) {
        // Ici, vous devez déterminer Id_Professeur et Id_resource en fonction de votre logique d'application
        $id_professeur = 1; // Remplacez par l'Id_Professeur approprié
        $id_resource = 1;   // Remplacez par l'Id_resource approprié

        // Exécution de la requête SQL pour mettre à jour ou insérer les notes
        try {
            $stmt_update_note->bindParam(':note', $note, PDO::PARAM_INT);
            $stmt_update_note->bindParam(':id_controle', $id_controle, PDO::PARAM_INT);
            $stmt_update_note->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
            $stmt_update_note->execute();
        } catch (PDOException $e) {
            // En cas d'échec de la mise à jour, essayez d'insérer la note
            $stmt_insert_note->bindParam(':note', $note, PDO::PARAM_INT);
            $stmt_insert_note->bindParam(':id_controle', $id_controle, PDO::PARAM_INT);
            $stmt_insert_note->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
            $stmt_insert_note->bindParam(':id_professeur', $id_professeur, PDO::PARAM_INT);
            $stmt_insert_note->bindParam(':id_resource', $id_resource, PDO::PARAM_INT);
            $stmt_insert_note->execute();
        }
    }

    echo "Les notes ont été mises à jour avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les Notes</title>
    <link rel="stylesheet" href="../Css/Evaluation.css">
    <style>
        .arrow{
    margin-top: 20px;
    margin-left: 30px;
        width: 100px;
        height: 40px;
        border: 3px solid #00000;
        border-radius: 45px;
        transition: all 0.3s;
        cursor: pointer;
        font-size: 1.2em;
        font-weight: 550;
        font-family: 'Montserrat', sans-serif;
        background: linear-gradient(45deg, #00fca8, #1cdaff);
      }
      
.arrow:hover {
        background: #FFFFFF;
        color: black;
        font-size: 1.5em;
      
}
    </style>
</head>
<body>
<div class="header">
        <div class="logo">
            <a href="Acceuilprof.php"><img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker"></a>
        </div>
        <div class="nav">
        <button class="nav-button"><a href="ProfilP.php"><img src="../Images/Profil.png" alt="profil">Profil</a></button>
        <button class="nav-button"><a href="EvalLien.php"><img src="../Images/Notes.png" alt="eval">Evaluation</a></button>
        </div>
        <form action="Déco.php" method="post">
            <div class="logout">
                <button class="logout-button" type="submit"><strong>Déconnexion</strong></button>
            </div>
        </form>
    </div>

    <a href="Evaluation.php?id=<?= htmlspecialchars($id) ?>"><button class="arrow" id="arrow" name="arrow"><</button></a>


    <div class="container">
        <h2>Modifier les Notes pour l'évaluation : <?= htmlspecialchars($evaluationData['nom_controle']) ?></h2>
        
        <form method="post" action="ModiNote.php?id=<?= htmlspecialchars($id) ?>">
            <input type="hidden" name="id_controle" value="<?= htmlspecialchars($id) ?>">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Note Actuelle</th>
                        <th>Nouvelle Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students_data as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['Id_Etudiant']) ?></td>
                            <td><?= htmlspecialchars($student['nom']) ?></td>
                            <td><?= htmlspecialchars($student['prénom']) ?></td>
                            <td><?= htmlspecialchars($student['Note']) ?></td>
                            <td><input type="number" name="note[<?= htmlspecialchars($student['Id_Etudiant']) ?>]" value="<?= htmlspecialchars($student['Note']) ?>"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="actions">
                <button type="submit" class="save-button">Enregistrer</button>
                <button type="button" id="ajouterNote" class="ajouter-button">Ajouter</button>
            </div>
        </form>
    </div>
</body>
</html>
