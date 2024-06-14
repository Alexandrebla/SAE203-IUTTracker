<?php
// Vérifie si l'ID de l'étudiant est présent dans l'URL
if(isset($_GET['id'])) {
    // Récupère l'ID de l'étudiant depuis l'URL
    $id_etudiant = $_GET['id'];

    // Database connection details
    $serveur = "mysql-hamonbrouillard.alwaysdata.net";
    $utilisateur = "362372";
    $motdepasse = "tructruc123*";
    $basededonnees = "hamonbrouillard_iuttracker";

    try {
        // Connecter à la base de données avec PDO
        $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête pour récupérer les données de l'étudiant avec l'ID spécifié
        $query = "SELECT * FROM Etudiant WHERE Id_Etudiant = :id";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':id', $id_etudiant);
        $stmt->execute();
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        // Requête pour récupérer les classes
        $queryClasses = "SELECT Id_Classe, nom_classe FROM Classe";
        $stmtClasses = $connexion->query($queryClasses);
        $classes = $stmtClasses->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un étudiant</title>
    <link rel="stylesheet" href="../Css/form.css">
    <style>
    select {
    padding: 10px;
    margin-bottom: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
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

    <a href="VuEleve.php"><button class="arrow" id="arrow" name="arrow"><</button></a>

    <h1>Modifier les données de l'étudiant</h1>
    <div class="container">
        <form action="modifierEleve.php" method="post">
            <input type="hidden" name="id" value="<?php echo $etudiant['Id_Etudiant']; ?>">
            <label for="ID">ID</label>
            <input type="number" id="ID" name="ID" value="<?php echo $etudiant['Id_Etudiant']; ?>" disabled>
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo $etudiant['prénom']; ?>">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?php echo $etudiant['nom']; ?>">
            <label for="mail">Mail Universitaire</label>
            <input type="email" id="mail" name="mail" value="<?php echo $etudiant['mail_univ']; ?>">
            <label for="télé">Numero de téléphone</label>
            <input type="text" id="télé" name="télé" value="<?php echo $etudiant['téléphone']; ?>">
            <label for="classe">Classe</label>
            <select name="classe" id="classe">
                <?php foreach ($classes as $classe) { ?>
                    <option value="<?php echo $classe['Id_Classe']; ?>" <?php if($etudiant['Id_Classe'] == $classe['Id_Classe']) echo 'selected'; ?>><?php echo $classe['nom_classe']; ?></option>
                <?php } ?>
            </select>
            <label for="login">Identifiant de connexion</label>
            <input type="text" id="login" name="login" value="<?php echo $etudiant['login_etudiant']; ?>">
            <label for="mdp">Mot de passe</label>
            <input type="text" id="mdp" name="mdp" value="<?php echo $etudiant['mdp_etudiant']; ?>">
            

            <button type="submit" name="submit" class="submit-button">Valider</button>
        </form>
    </div>
</body>
</html>
