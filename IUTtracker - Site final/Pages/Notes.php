<?php
session_start(); // Start the session

// Database connection details
$serveur = "mysql-hamonbrouillard.alwaysdata.net";
$utilisateur = "362372";
$motdepasse = "tructruc123*";
$basededonnees = "hamonbrouillard_iuttracker";

try {
    // Connect to the database with PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user is logged in
    if (!isset($_SESSION['id_etudiant'])) {
        // Redirect to the login page if not logged in
        header('Location: login.php');
        exit();
    }

    // Now you can use $_SESSION['id_etudiant'] to retrieve the student's ID
    $idEtudiant = $_SESSION['id_etudiant'];

    // Requête SQL pour récupérer les contrôles, les notes et d'autres données associées de l'étudiant
    $query = $connexion->prepare("SELECT c.nom_controle, c.date, c.durée, c.type, c.coeff, n.Note 
                                  FROM Contrôle c
                                  LEFT JOIN Notation n ON c.Id_Contrôle = n.Id_Contrôle AND n.Id_Etudiant = :idEtudiant");
    $query->bindParam(':idEtudiant', $idEtudiant);
    $query->execute();
    $resultats = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}

// Calcul de la moyenne des notes en tenant compte des coefficients

// Initialisation des variables pour calculer la moyenne
$totalNotes = 0; // Total des notes
$totalCoefficients = 0; // Total des coefficients
$notesCount = 0; // Nombre de notes non nulles

// Parcourir les résultats pour calculer la somme des notes pondérées
foreach ($resultats as $row) {
    // Vérifier si la note est renseignée
    if ($row['Note'] !== null) {
        $notesCount++; // Incrémenter le compteur de notes non nulles
        $totalNotes += $row['Note'] * $row['coeff']; // Ajouter la note pondérée au total des notes
        $totalCoefficients += $row['coeff']; // Ajouter le coefficient au total des coefficients
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil Etudiant</title>
    <link rel="stylesheet" href="../Css/Notes.css">
    <style>
        /* Ajout de styles CSS pour colorer les cellules de la colonne "Note" */

.above-10 {
    background-color: #c8e6c9; /* Vert pour les notes supérieures à 10 */
}

.equal-10,
.equal-9,
.equal-8 {
    background-color: #fff59d; /* Jaune pour les notes égales à 10, 9 et 8 */
}

.below-8 {
    background-color: #ef9a9a; /* Rouge pour les notes inférieures à 8 */
}

.nav {
    display: flex;
    list-style-type: none;
    padding: 0;
    gap: 30px;
    align-items: center;
    width: 200px;
    justify-content: center;
}

.nav-button {
    background: none;
    border: none;
    margin: 0 10px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    color: rgb(1, 0, 0);
    padding: 10px;
}

.nav-button img {
    width: 50px; 
    height: auto;
}
h3{
    font-size: 50px;
    text-align:center;
    margin-top: 30px;
}
h1{
    text-align:center;
    margin-top: 50px;
    font-size: 60px;
}
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class="logo"><a href="Notes.php"><img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker"></div></a>
        </div>
        <div class="nav">
            <button class="nav-button"><a href="ProfilE.php"><img src="../Images/Profil.png" alt="profil">Profil</a></button>
        </div>
        <form action="Déco.php" method="post">
        <div class="logout">
            <a href="../index.html"><button class="logout-button"><strong>Déconnexion</strong></button></a>
        </div>
        </div>
        </form>

        <div class="container">
            <h3>Tableau de notes</h3>
            <table id="notes-table">
                <tbody>
                <?php // Afficher les résultats dans un tableau
                    echo "<table border='1'>
                            <tr>
                                <th><h2>Nom du contrôle</h2></th>
                                <th><h2>Date</h2></th>
                                <th><h2>Durée</h2></th>
                                <th><h2>Type</h2></th>
                                <th><h2>Coefficient</h2></th>
                                <th><h2>Note</h2></th>
                            </tr>";
                    foreach ($resultats as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['nom_controle'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['durée'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['coeff'] . "</td>";

                        // Ajouter une classe dynamiquement en fonction de la valeur de la note
                        $noteClass = '';
                        if ($row['Note'] > 10) {
                            $noteClass = 'above-10';
                        } elseif ($row['Note'] == 10 || $row['Note'] == 9 || $row['Note'] == 8) {
                            $noteClass = 'equal-10';
                        } elseif ($row['Note'] < 8) {
                            $noteClass = 'below-8';
                        }

                        // Afficher la note avec la classe appropriée
                        echo "<td class='$noteClass'>" . ($row['Note'] ? $row['Note'] : 'non noté') . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; ?>
                </tbody>
            </table>
            <div class="average">
                <?php
                // Vérifier s'il y a au moins une note non nulle
                if ($notesCount > 0) {
                    // Calculer la moyenne
                    $moyenne = $totalNotes / $totalCoefficients;

                    // Afficher la moyenne avec 3 chiffres après la virgule
                    echo "<p><h1>Moyenne : <span id='average'>" . number_format($moyenne, 3) . "</span></h1></p>";
                } else {
                    // Si aucune note n'est renseignée, afficher "Moyenne : aucune note"
                    echo "<p><h1>Moyenne : aucune note</h1></p>";
                }
                ?>
            </div>
        </div>
        <script src="/Script/Notes.js"></script>
</body>
</html>
