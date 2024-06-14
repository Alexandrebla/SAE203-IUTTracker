<?php
// Paramètres de connexion à la base de données
$serveur = "mysql-hamonbrouillard.alwaysdata.net";
$utilisateur = "362372";
$motdepasse = "tructruc123*";
$basededonnees = "hamonbrouillard_iuttracker";

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête de sélection des enseignants
    $requete = "SELECT * FROM Professeur";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    // Récupération des données sous forme de tableau associatif
    $enseignants = $resultat->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IUT Tracker - Ajouter un enseignant</title>
    <link rel="stylesheet" href="../Css/vu.css">
    <script>
function confirmDelete(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce professeur ?")) {
        window.location.href = "supprimerProfesseur.php?id=" + id;
    }
}
</script>

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

.edit-button {
    background-color: #1EB6D3;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    color: white;
    border-radius: 5px;
    text-decoration: none;
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
        <h3>Liste des enseignants</h3>
        <button class="add-button"><a class="deco" href="formP.php">Ajouter un enseignant</a></button>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Mail Universitaire</th>
                    <th>Identifiant</th>
                    <th>Mot de passe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
    <?php foreach ($enseignants as $enseignant): ?>
        <tr>
            <td><?php echo $enseignant['Id_Professeur']; ?></td>
            <td><?php echo $enseignant['nom']; ?></td>
            <td><?php echo $enseignant['prénom']; ?></td>
            <td><?php echo $enseignant['mail_univ']; ?></td>
            <td><?php echo $enseignant['login_prof']; ?></td>
            <td><?php echo $enseignant['mdp_prof']; ?></td>
            <td>
    <a href="modifP.php?id=<?php echo $enseignant['Id_Professeur']; ?>" class="edit-button">Modifier</a>
    <button class="delete-button" onclick="confirmDelete(<?php echo $enseignant['Id_Professeur']; ?>)">Supprimer</button>
</td>


        </tr>
    <?php endforeach; ?>
</tbody>

            </tbody>
        </table>
    </div>
</body>
</html>
