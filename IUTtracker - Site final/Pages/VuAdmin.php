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
        <h1>Tableau de bord administrateur</h1>
        <h3>Liste des administrateurs</h3>
        <button class="add-button"><a class="deco" href="formA.php">Ajouter un administrateur</a></button>
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
                <?php
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
                    $sql = "SELECT Id_admin, Nom_admin, prénom_admin, mail_univ, login_admin, mdp_admin FROM Administrateur";
                    $stmt = $connexion->prepare($sql);
                    $stmt->execute();

                    // Fetch all the results
                    $administrateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Loop through the results and generate table rows
                    foreach ($administrateurs as $admin) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($admin['Id_admin']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['Nom_admin']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['prénom_admin']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['mail_univ']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['login_admin']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['mdp_admin']) . "</td>";
                        echo "<td>
                                    <form action='modifA.php' method='post'>
                                        <input type='hidden' name='id_admin' value='" . htmlspecialchars($admin['Id_admin']) . "'>
                                        <button type='submit' class='edit-button' name='modifier'>Modifier</button>
                                    </form>
                                    <form action='supprimerAdmin.php' method='post' onsubmit=\"return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?')\">
                                        <input type='hidden' name='id_admin' value='" . htmlspecialchars($admin['Id_admin']) . "'>
                                        <button type='submit' class='delete-button' name='supprimer'>Supprimer</button>
                                        </form>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                }

                // Close the connection
                $connexion = null;
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
