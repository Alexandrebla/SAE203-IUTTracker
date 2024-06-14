<?php
// Informations de connexion à la base de données
$serveur = "mysql-hamonbrouillard.alwaysdata.net";
$utilisateur = "362372";
$motdepasse = "tructruc123*";
$basededonnees = "hamonbrouillard_iuttracker";

try {
    // Création de l'objet PDO
    $pdo = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    
    // Configuration des attributs de PDO pour gérer les erreurs et les exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Requête SQL pour récupérer les données nécessaires
    $sql = "SELECT Resource.Id_resource, Resource.Nom AS NomResource, UE.Nom AS NomUE
        FROM Resource
        INNER JOIN UE ON Resource.Id_UE = UE.Id_UE
        ORDER BY Resource.Id_resource ASC";

    
    // Préparation de la requête
    $stmt = $pdo->prepare($sql);
    
    // Exécution de la requête
    $stmt->execute();
    
    // Récupération des résultats
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution de requête
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IUT Tracker - Vue Administrateur</title>
    <link rel="stylesheet" href="../Css/vu.css">
    <style>
        .delete-button{
            margin-top:10px;
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
    </style>
    <script>
    function supprimerRessource(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette ressource ?")) {
            window.location.href = 'supprimer.php?id=' + id;
        }
    }
</script>

</head>
<body>
    <div class="header">
        <div class="logo"><a href="AcceuilAdmin.php">
            <img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="IUT Tracker Logo">
        </a></div>
        <div class="nav">
            <button class="nav-button"><a href="ProfilA.php"><img src="../Images/Profil.png" alt="profil">Profil</a></button>
            <button class="nav-button"><a href="VuProf.php"><img src="../Images/prof.png" alt="prof">Gestion professeur</a></button>
            <button class="nav-button"><a href="VuEleve.php"><img src="../Images/Notes.png" alt="élève">Gestion élève</a></button>
            <button class="nav-button"><a href="VuAdmin.php"><img src="../Images/admin.png" alt="admin">Gestion admin</a></button>
            <button class="nav-button"><a href="Res.php"><img src="../Imgaes/livre.png" alt="Manuel scolaire">Gestion des Ressource</a></button>
        </div>
        <form action="Déco.php" method="post">
            <div class="logout">
                <a href="../index.html"><button class="logout-button"><strong>Déconnexion</strong></button></a>
            </div>
        </form>
    </div>

    <div class="container">
        <h1>Tableau de bord Ressource</h1>
        <h3>Liste des Ressources</h3>
        <button class="add-button"><a class="deco" href="FormR.php">Ajouter une Ressource</a></button>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>UE</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
            <?php foreach ($resultats as $row): ?>
    <tr>
        <td><?php echo $row['Id_resource']; ?></td>
        <td><?php echo $row['NomResource']; ?></td>
        <td><?php echo $row['NomUE']; ?></td>
        <td>
            <a href="ModifR.php?id=<?php echo $row['Id_resource']; ?>" class="edit-button">Modifier</a>
            <button onclick="supprimerRessource(<?php echo $row['Id_resource']; ?>)" class="delete-button">Supprimer</button>
        </td>
    </tr>
<?php endforeach; ?>

</tbody>

             
            </tbody>
        </table>
    </div>
</body>
</html>
