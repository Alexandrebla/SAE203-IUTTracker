<?php
// Database connection details
$serveur = "mysql-hamonbrouillard.alwaysdata.net";
$utilisateur = "362372";
$motdepasse = "tructruc123*";
$basededonnees = "hamonbrouillard_iuttracker";

try {
    // Connecter à la base de données avec PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les étudiants
    $query = "SELECT * FROM Etudiant";
    $stmt = $connexion->query($query);
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="../Css/vu.css">
    <script>
function confirmDelete() {
    return confirm("Êtes-vous sûr de vouloir supprimer cet étudiant ?");
}
</script>
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

    <div class="container">
        <h1>Tableau de bord administrateur</h1>
        <h3>Liste des étudiants</h3>
        <button class="add-button"><a class="deco" href="formE.php">Ajouter un étudiant</a></button>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Mail Universitaire</th>
                    <th>Téléphone</th>
                    <th>Classe</th>
                    <th>Identifiant</th>
                    <th>Mot de passe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Affichage des données des étudiants -->
                <?php foreach ($etudiants as $etudiant) { ?>
                    <tr>
                        <td><?php echo $etudiant['Id_Etudiant']; ?></td>
                        <td><?php echo $etudiant['nom']; ?></td>
                        <td><?php echo $etudiant['prénom']; ?></td>
                        <td><?php echo $etudiant['mail_univ']; ?></td>
                        <td><?php echo $etudiant['téléphone']; ?></td>
                        <td><?php echo $etudiant['Id_Classe']; ?></td>
                        <td><?php echo $etudiant['login_etudiant']; ?></td>
                        <td><?php echo $etudiant['mdp_etudiant']; ?></td>
                        <td>
    <a href="modifE.php?id=<?php echo $etudiant['Id_Etudiant']; ?>" class="edit-button">Modifier</a>
    <form action="supprimerEleve.php" method="post">
    <input type="hidden" name="id" value="<?php echo $etudiant['Id_Etudiant']; ?>">
    <button type="submit" class="delete-button" onclick="return confirmDelete()">Supprimer</button>

</form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
