<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un administrateur</title>
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
            <a href="AcceuilAdmin.php"><img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker"></a>
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

    <a href="VuAdmin.php"><button class="arrow" id="arrow" name="arrow"><</button></a>

    <div class="container">
        <h1>Modifier les données de l'administrateur</h1>
        <?php
        if (isset($_POST['modifier'])) {
            $id_admin = $_POST['id_admin'];
            
            // Database connection details
            $serveur = "mysql-hamonbrouillard.alwaysdata.net";
            $utilisateur = "362372";
            $motdepasse = "tructruc123*";
            $basededonnees = "hamonbrouillard_iuttracker";

            try {
                // Connect to the database with PDO
                $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare and execute the SQL query
                $sql = "SELECT Id_admin, Nom_admin, prénom_admin, mail_univ, login_admin, mdp_admin 
                        FROM Administrateur WHERE Id_admin= :id_admin";
                $stmt = $connexion->prepare($sql);
                $stmt->bindParam(':id_admin', $id_admin, PDO::PARAM_INT);
                $stmt->execute();
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                // Affichage du formulaire avec les données de l'administrateur
                echo "<form action='modifierAdmin.php' method='post'>";
                echo "<input type='hidden' name='id_admin' value='" . htmlspecialchars($admin['Id_admin']) . "'>";
                echo "<label for='prenom'>Prénom</label>";
                echo "<input type='text' id='prenom' name='prenom' value='" . htmlspecialchars($admin['prénom_admin']) . "' required>";
                echo "<label for='nom'>Nom</label>";
                echo "<input type='text' id='nom' name='nom' value='" . htmlspecialchars($admin['Nom_admin']) . "' required>";
                echo "<label for='mail'>Mail Universitaire</label>";
                echo "<input type='email' id='mail' name='mail' value='" . htmlspecialchars($admin['mail_univ']) . "' required>";
                echo "<label for='login'>Identifiant de connexion</label>";
                echo "<input type='text' id='login' name='login' value='" . htmlspecialchars($admin['login_admin']) . "' required>";
                echo "<label for='mdp'>Mot de Passe</label>";
                echo "<input type='text' id='mdp' name='mdp' value='" . htmlspecialchars($admin['mdp_admin']) . "' required>";
                echo "<button type='submit' class='submit-button'>Valider</button>";
                echo "</form>";

            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
            }

            // Fermer la connexion
            $connexion = null;
        }
        ?>
    </div>
</body>
</html>
