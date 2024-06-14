<?php
// Vérifier si l'ID du professeur est fourni dans la requête GET
if(isset($_GET['id'])) {
    $id_professeur = $_GET['id'];

    // Paramètres de connexion à la base de données
    $serveur = "mysql-hamonbrouillard.alwaysdata.net";
    $utilisateur = "362372";
    $motdepasse = "tructruc123*";
    $basededonnees = "hamonbrouillard_iuttracker";

    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête pour récupérer les données du professeur correspondant à l'ID
        $requete = "SELECT * FROM Professeur WHERE Id_Professeur = :id";

        // Préparation de la requête
        $statement = $connexion->prepare($requete);

        // Liaison des paramètres
        $statement->bindParam(':id', $id_professeur);

        // Exécution de la requête
        $statement->execute();

        // Récupération des données du professeur
        $professeur = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // Redirection vers VuProf.php si aucun ID n'est fourni
    header('Location: VuProf.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un enseignant</title>
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
        </div>
        </form>
    </div>

    <a href="VuProf.php"><button class="arrow" id="arrow" name="arrow"><</button></a>

    <div class="container">
        <h1>Modifier les données de l'enseignant</h1>
        <form action="traitementModifProf.php" method="post">
            <label for="ID">ID</label>
            <input type="text" id="ID" name="ID" value="<?php echo $professeur['Id_Professeur']; ?>">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo $professeur['prénom']; ?>">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?php echo $professeur['nom']; ?>">
            <label for="mail">Mail Universitaire</label>
            <input type="email" id="mail" name="mail" value="<?php echo $professeur['mail_univ']; ?>">
            <label for="login">Identifiant de connexion</label>
            <input type="text" id="login" name="login" value="<?php echo $professeur['login_prof']; ?>">
            <label for="mdp">Mot de passe</label>
            <input type="text" id="mdp" name="mdp" value="<?php echo $professeur['mdp_prof']; ?>">
            <button type="submit" class="submit-button">Valider</button>
        </form>
    </div>
</body>
</html>
