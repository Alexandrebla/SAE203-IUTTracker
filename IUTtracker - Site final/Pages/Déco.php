<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté et a appuyé sur le bouton de déconnexion
if(isset($_POST['logout'])) {
    // Détruit toutes les données de session
    session_destroy();
    
    // Redirige l'utilisateur vers la page d'accueil ou une autre page appropriée
    header("Location: ../index.html");
    //exit; // Assure que le script s'arrête après la redirection
}
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Css/index.css">
    <title>Document</title>
</head>
<body>
    <p><h1>Vous vous ètes déconnecter avec succès !</h1></p>
<p>Si vous souhaitez vous réconnecter <a href="../index.php">Cliquez ici !</a></p>
</body>
</html> -->
<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../Css/index.css">
        <title>IutTracker</title>
        <style>
        .form-container {
            text-align: center; /* Pour centrer les éléments à l'intérieur */
        }

        .login-container {
            display: inline-block;
            margin: 0 10px; /* Espacement entre les formulaires */
            vertical-align: top; /* Alignement en haut */
        }
        p{
            font-size: 50px;
            font-family: times;
            margin-top: 30px;
        }
        h2{
            font-size: 70px;
            margin-bottom: 50px;
        }
    </style>
    </head>
    <body>
        
        <div class="form-container"><div class="logo-container">
            <img class="logo1" src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker">
            <img class="logo2" src="../Images/1280px-Logo_Université_Gustave_Eiffel_2020.svg.png" alt="univ">
        </div>
        <h2>Vous vous déconnecté avec succès !</h2>
        <p>Connexion</p>
        <div class="login-container">
            <h1>Etudiant</h1>
            <form action="Connexion_etudiant.php" method="post" id="loginForm">
                <input type="text" id="login_etudiant" name="login_etudiant" placeholder="Identifiant" required>
                <input type="password" id="mdp_etudiant" name="mdp_etudiant" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
        </div>
        <div class="login-container">
            <h1>Professeur</h1>
            <form action="Connexion_prof.php" method="post" id="loginForm1">
                <input type="text" id="login_prof" name="login_prof" placeholder="Identifiant" required>
                <input type="password" id="mdp_prof" name="mdp_prof" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
        </div>
        <div class="login-container">
            <h1>Administrateur</h1>
            <form action="Connexion_admin.php" method="post" id="loginForm2">
                <input type="text" id="login_admin" name="login_admin" placeholder="Identifiant" required>
                <input type="password" id="mdp_admin" name="mdp_admin" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>
  </body>
</html>
