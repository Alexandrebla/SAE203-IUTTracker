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
$controlData = null;

if ($id) {
    // Préparer et exécuter la requête pour récupérer les données du contrôle
    $query = $bdd->prepare("SELECT * FROM Contrôle WHERE Id_Contrôle = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $controlData = $query->fetch(PDO::FETCH_ASSOC);
}

// Requête SQL pour sélectionner les noms des ressources
$sql_resources = "SELECT Nom FROM Resource";
$stmt_resources = $bdd->prepare($sql_resources);
$stmt_resources->execute();
$resources = $stmt_resources->fetchAll(PDO::FETCH_ASSOC);

// Requête SQL pour sélectionner les noms des classes
$sql_classes = "SELECT nom_classe FROM Classe";
$stmt_classes = $bdd->prepare($sql_classes);
$stmt_classes->execute();
$classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);

// Requête SQL pour sélectionner les noms des enseignants
$sql_professors = "SELECT CONCAT(nom, ' ', prénom) AS full_name FROM Professeur";
$stmt_professors = $bdd->prepare($sql_professors);
$stmt_professors->execute();
$professors = $stmt_professors->fetchAll(PDO::FETCH_ASSOC);

// Récupérer l'ID du contrôle à partir de l'URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
$controlData = null;

if ($id) {
    // Préparer et exécuter la requête pour récupérer les données du contrôle
    $query = $bdd->prepare("SELECT * FROM Contrôle WHERE Id_Contrôle = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $controlData = $query->fetch(PDO::FETCH_ASSOC);
}

// Requête SQL pour sélectionner les notes des étudiants pour le contrôle spécifique
$sql_students_notes = "SELECT Etudiant.Id_Etudiant, Etudiant.nom, Etudiant.prénom, Classe.nom_classe, IFNULL(Notation.Note, 'Non noté') AS Note 
                      FROM Etudiant 
                      JOIN Classe ON Etudiant.Id_Classe = Classe.Id_Classe 
                      LEFT JOIN Notation ON Etudiant.Id_Etudiant = Notation.Id_Etudiant AND Notation.Id_Contrôle = :id";

if (isset($_POST['classe']) && $_POST['classe'] !== 'promo' && $_POST['classe'] !== '') {
    $sql_students_notes .= " WHERE Classe.nom_classe = :classe";
}
$stmt_students_notes = $bdd->prepare($sql_students_notes);
if (isset($_POST['classe']) && $_POST['classe'] !== 'promo' && $_POST['classe'] !== '') {
    $stmt_students_notes->bindParam(':classe', $_POST['classe'], PDO::PARAM_STR);
}
$stmt_students_notes->bindParam(':id', $id, PDO::PARAM_INT);
$stmt_students_notes->execute();
$students_notes = $stmt_students_notes->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IUT Tracker - Évaluation</title>
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

    <a href="EvalLien.php"><button class="arrow" id="arrow" name="arrow"><</button></a>

    <?php if ($controlData): ?>
    <h2>Détails de l'évaluation</h2>
    <table>
        <tr>
            <th>ID du contrôle</th>
            <td><?= htmlspecialchars($controlData['Id_Contrôle']) ?></td>
        </tr>
        <tr>
            <th>Nom du contrôle</th>
            <td><?= htmlspecialchars($controlData['nom_controle']) ?></td>
        </tr>
        <tr>
            <th>Date</th>
            <td><?= htmlspecialchars($controlData['date']) ?></td>
        </tr>
        <tr>
            <th>Durée</th>
            <td><?= htmlspecialchars($controlData['durée']) ?></td>
        </tr>
        <tr>
            <th>Type</th>
            <td><?= htmlspecialchars($controlData['type']) ?></td>
        </tr>
        <tr>
            <th>Coefficient</th>
            <td><?= htmlspecialchars($controlData['coeff']) ?></td>
        </tr>
        <tr>
            <th>Enseignant</th>
            <td><?= isset($_POST['enseignant']) ? htmlspecialchars($_POST['enseignant']) : '' ?></td>
        </tr>
        <tr>
            <th>Ressource</th>
            <td><?= isset($_POST['ressource']) ? htmlspecialchars($_POST['ressource']) : '' ?></td>
        </tr>
    </table>
    <div class="container">
        <h2>Tableau de notes</h2>
        
        <form method="post" action="Evaluation.php?id=<?= htmlspecialchars($id) ?>">
            <div class="filters">
                <div class="filter-group">
                    <select name="ressource">
                        <option value="">Entrez la Ressource</option>
                        <?php
                        // Affichage des options du menu déroulant avec les noms des ressources
                        foreach ($resources as $resource) {
                            echo "<option value='" . $resource['Nom'] . "'>" . $resource['Nom'] . "</option>";
                        }
                        ?>
                    </select>
                    
                    <input type="number" name="coeff" placeholder="Coeff">
                    
                    <select name="type_evaluation">
                        <option value="">Type d'évaluation</option>
                        <option value="SAé">SAé</option>
                        <option value="Test">Test</option>
                        <option value="Partiel">Partiel</option>
                    </select>
                </div>
                <div class="filter-group">
                    <select name="enseignant">
                        <option value="">Enseignant</option>
                        <?php
                        // Affichage des options du menu déroulant avec les noms des enseignants
                        foreach ($professors as $professor) {
                            echo "<option value='" . $professor['full_name'] . "'>" . $professor['full_name'] . "</option>";
                        }
                        ?>
                    </select>
                    
                    <input type="text" name="name" placeholder="Nom de l'évaluation">
                    
                    <input type="number" name="dur" placeholder="Durée">
                    
                    <select name="classe">
                        <option value="">Classe</option>
                        <option value="promo">Promo</option>
                        <?php
                        // Affichage des options du menu déroulant avec les noms des classes
                        foreach ($classes as $class) {
                            echo "<option value='" . $class['nom_classe'] . "'>" . $class['nom_classe'] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="date" name="date_evaluation">
                    <button type="submit" class="filter-button">✔</button>
                </div>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Etudiant</th>
                    <th>Classe</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Affichage des informations des étudiants dans le tableau avec leurs notes
            foreach ($students_notes as $student_note) {
                echo "<tr>";
                echo "<td>" . $student_note['Id_Etudiant'] . "</td>";
                echo "<td>" . $student_note['prénom'] . " " . $student_note['nom'] . "</td>";
                echo "<td>" . $student_note['nom_classe'] . "</td>";
                echo "<td>" . $student_note['Note'] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <div class="actions">
            <button class="save-button"><a class="deco" href="EvalLien.php">Enregistrer</a></button>
            <button class="publish-button"><a class="deco" href="EvalLien.php">Publier</a></button>
            <!-- Ajouter un bouton Modifier sous le tableau -->
            <button class="modify-button"><a class="deco" href="ModiNote.php?id=<?= htmlspecialchars($id) ?>">Modifier</a></button>
        </div>
    </div>
    <?php else: ?>
    <p>Aucune donnée trouvée pour cette évaluation.</p>
    <?php endif; ?>
</body>
</html>
