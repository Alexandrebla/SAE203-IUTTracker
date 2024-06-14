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

// Traitement de la suppression d'une évaluation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $deleteQuery = $bdd->prepare("DELETE FROM Contrôle WHERE Id_Contrôle = :id");
    $deleteQuery->bindParam(':id', $deleteId, PDO::PARAM_INT);
    $deleteQuery->execute();
    header('Location: EvalLien.php');
    exit;
}

// Requête pour récupérer les données
$query = $bdd->prepare("SELECT * FROM Contrôle");
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IUT Tracker - Nouvelle évaluation</title>
    <link rel="stylesheet" href="../Css/EvalLien.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit-button, .delete-button {
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-button {
            background-color: #4CAF50;
        }
        .edit-button:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: #f44336;
        }
        .delete-button:hover {
            background-color: #e53935;
        }
        /* Ajout des styles pour le popup modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }.nav-button img {
    width: 50px; 
    height: auto;
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
    </div>
    <h2>Liste des contrôles</h2>
    <div class="container">
        <h2>Créer une nouvelle évaluation</h2>
        <div class="form">
            <input type="text" id="evaluation-name" placeholder="Nom de l'évaluation">
            <button class="create-button" onclick="openCreateEvaluationPopup()">Créer</button>
        </div>
        <div id="create-evaluation-popup" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeCreateEvaluationPopup()">&times;</span>
                <h2>Créer une nouvelle évaluation</h2>
                <form id="create-evaluation-form" method="post" action="add_evaluation.php">
                    <label for="id-controle">ID Contrôle:</label>
                    <input type="number" id="id-controle" name="id-controle" required><br>
                    <label for="nom-controle">Nom du contrôle:</label>
                    <input type="text" id="nom-controle" name="nom-controle" required><br>
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required><br>
                    <label for="type">Type:</label>
                    <select name="type" id="type">
                        <option value="">Type d'évaluation</option>
                        <option value="Test">Test</option>
                        <option value="SAé">SAé</option>
                        <option value="Partiel">Partiel</option>
                    </select><br>
                    <label for="duree">Durée:</label>
                    <input type="number" id="duree" name="duree" required><br>
                    <label for="coeff">Coefficient:</label>
                    <input type="number" id="coeff" name="coeff" step="0.01" required><br>
                    <button type="button" onclick="createEvaluation()" id="create-button-popup">Créer</button>
                </form>
            </div>
        </div>
        <div class="link-container" id="link-container">
            <!-- Link to the created evaluation will appear here -->
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Id Contrôle</th>
                <th>Nom Contrôle</th>
                <th>Date</th>
                <th>Durée</th>
                <th>Type</th>
                <th>Coeff</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?= $row['Id_Contrôle'] ?></td>
                <td><?= $row['nom_controle'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['durée'] ?></td>
                <td><?= $row['type'] ?></td>
                <td><?= $row['coeff'] ?></td>
                <td>
                    <button class="edit-button" onclick="editControl(<?= $row['Id_Contrôle'] ?>)">Modifier</button>
                    <form method="post" action="EvalLien.php" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $row['Id_Contrôle'] ?>">
                        <button type="submit" class="delete-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
    function editControl(controlId) {
        window.location.href = "Evaluation.php?id=" + controlId;
    }

    function openCreateEvaluationPopup() {
        var popupContainer = document.getElementById("create-evaluation-popup");
        popupContainer.style.display = "block";
    }

    function closeCreateEvaluationPopup() {
        var popupContainer = document.getElementById("create-evaluation-popup");
        popupContainer.style.display = "none";
    }

    function createEvaluation() {
        var idControle = document.getElementById("id-controle").value;
        var nomControle = document.getElementById("nom-controle").value;
        var date = document.getElementById("date").value;
        var type = document.getElementById("type").value;
        var duree = document.getElementById("duree").value;
        var coeff = document.getElementById("coeff").value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_evaluation.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                window.location.href = "EvalLien.php";
            }
        };
        xhr.send("id-controle=" + idControle + "&nom-controle=" + nomControle + "&date=" + date + "&type=" + type + "&duree=" + duree + "&coeff=" + coeff);
    }
    </script>
</body>
</html>
