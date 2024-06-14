<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil Admin</title>
    <link rel="stylesheet" href="../Css/Acceuil.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class="logo"><a href="AcceuilAdmin.php"><img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker"></div></a>
        </div>
        <div class="nav">
            <button class="nav-button"><a href="ProfilA.php"><img src="../Images/Profil.png" alt="profil">Profil</a></button>
            <button class="nav-button"><a href="VuProf.php"><img src="../Images/prof.png" alt="prof">Gestion des enseignants</a></button>
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

    <main class="but">
        <a href="VuProf.php"><button class="btn">Gestion des enseignants</button></a>
        <a href="VuEleve.php"><button class="btn">Gestion des étudiants</button></a>
        <a href="VuAdmin.php"><button class="btn">Gestion des administrateurs</button></a>
        <a href="Res.php"><button class="btn">Gestion des Ressource</button></a>
        <a href="ProfilA.php"><button class="btn">Mon profil</button></a>
        
    </main>
    
</body>
</html>
