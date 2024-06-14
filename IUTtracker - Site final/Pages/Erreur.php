<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../Css/index.css">
        <title>Erreur de connexion</title>
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
            font-size: 70px;
            font-family: times;
            margin-top: 30px;
        }
        h2{
    color: red;
    font-size: 60px;
}
    </style>
    </head>
    <body>
        
        <div class="form-container"><div class="logo-container">
            <img class="logo1" src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker">
            <img class="logo2" src="../Images/1280px-Logo_Université_Gustave_Eiffel_2020.svg.png" alt="univ">
        </div>
        <h2>Erreur : mauvais identifiant ou mot de passe. Veuillez réessayer !</h2>
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