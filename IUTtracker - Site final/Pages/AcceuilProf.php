<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil Enseignant</title>
    <link rel="stylesheet" href="../Css/Acceuil.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class="logo"><a href="AcceuilProf.php"><img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker"></div></a>
        </div>
        <div class="nav">
            <button class="nav-button"><a href="ProfilP.php"><img src="../Images/Profil.png" alt="profil">Profil</a></button>
            <button class="nav-button"><a href="EvalLien.php"><img src="../Images/Notes.png" alt="eval">Evaluation</a></button>
        </div>
        <form action="Déco.php" method="post">
            <div class="logout">
                <a href="../index.html"><button class="logout-button"><strong>Déconnexion</strong></button></a>
            </div>
        </form>

    </div>

        <main class="but">
            <a href="EvalLien.php"><button class="btn">Evaluations</button></a>
            <a href="ProfilP.php"><button class="btn">Mon profil</button></a>
        </main>
</body>
</html>