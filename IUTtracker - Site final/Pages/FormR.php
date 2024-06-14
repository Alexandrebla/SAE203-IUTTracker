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
    
    // Requête SQL pour récupérer les noms des UE
    $sql_ue = "SELECT Id_UE, Nom FROM UE";
    
    // Préparation de la requête
    $stmt_ue = $pdo->prepare($sql_ue);
    
    // Exécution de la requête
    $stmt_ue->execute();
    
    // Récupération des résultats
    $ues = $stmt_ue->fetchAll(PDO::FETCH_ASSOC);
    
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
    <title>Ajouter une Ressource</title>
    <link rel="stylesheet" href="../Css/form.css">

<style>
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
select {
    padding: 10px;
    margin-bottom: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
}
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
            <div class="logo"><a href="AcceuilAdmin.php"><img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker"></div></a>
        </div>
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

    <a href="Res.php"><button class="arrow" id="arrow" name="arrow"><</button></a>

    <div class="container">
        <form action="addr.php" method="post">
            <label for="ID">ID</label>
            <input type="number" id="ID" name="ID" required>

            <label for="nom">Nom Ressource</label>
            <input type="text" id="nom" name="nom" required>

            <label for="ue">UE</label>
            <select name="ue" id="ue">
                <option value="">Sélectionnez une UE</option>
                <?php foreach ($ues as $ue): ?>
                    <option value="<?php echo $ue['Id_UE']; ?>"><?php echo $ue['Nom']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            
            <button type="submit" class="submit-button">Valider</button>
        </form>    
    </div>
</body>
</html>
