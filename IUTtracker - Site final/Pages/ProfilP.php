<?php
session_start(); // Démarre la session

// Assurez-vous que l'administrateur est connecté
if (!isset($_SESSION['id_professeur'])) {
    header('Location: ../index.php');
    exit();
}

// Récupération des données de l'administrateur depuis la session
$prenom_prof = $_SESSION['prenom'];
$nom_prof = $_SESSION['nom'];
$mail_univ = $_SESSION['mail_univ'];
$login_prof = $_SESSION['login_prof'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Professeur</title>
    <link rel="stylesheet" href="../Css/Profils.css">
    <style>
        /* Insérer le CSS du popup ici */
        .popup {
            display: none; /* Masqué par défaut */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0); /* Couleur de secours */
            background-color: rgba(0,0,0,0.4); /* Noir avec opacité */
        }

        .popup-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% depuis le haut et centré */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Peut être plus ou moins, selon la taille de l'écran */
            max-width: 500px;
            border-radius: 10px;
            size:20px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .password-input {
        width: 100%; /* Ajuster la largeur selon les besoins */
        max-width: 300px; /* Vous pouvez ajuster cette valeur */
        padding: 8px;
        margin-top: 10px;
        margin-bottom: 10px;
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
            <a href="Acceuilprof.php"><img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker"></a>
        </div>
        <div class="nav">
        <button class="nav-button"><a href="ProfilP.php"><img src="../Images/Profil.png" alt="profil">Profil</a></button>
        <button class="nav-button"><a href="EvalLien.php"><img src="../Images/Notes.png" alt="eval">Evaluation</a></button>
        </div>
        <form action="Déco.php" method="post">
            <div class="logout">
                <button class="logout-button" type="submit"><strong>Déconnexion</strong></button>
            </div>
        </form>
    </div>

    <main>
        <div class="container">
            <form action="Connexion_prof.php">
                <div class="user-profile">
                    <br>
                    <h1><?php echo htmlspecialchars($prenom_prof . " " . $nom_prof); ?></h1>
                    <p><em><?php echo htmlspecialchars($mail_univ); ?></em></p>
                    <img src="../Images/prof.jpg" alt="Photo de profil">
                </div>
            </form>

            <div class="credentials">
                <label for="username">Identifiant :</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($login_prof); ?>">
                <br><br>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($mdp_prof); ?>">
                <br>
                <!-- Modifier le mot de passe en cliquant sur le bouton -->
                <button class="btn" id="modifier-btn" type="button">Modifier</button>
            </div>
        </div>
    </main>

    <!-- Le popup -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <!-- Bouton pour fermer le popup -->
            <span class="close" id="close-popup">&times;</span>
            <h2>Modifier le mot de passe</h2>
            <!-- Formulaire pour modifier le mot de passe -->
            <form action="update_password_prof.php" method="post">
                <label for="new-password">Nouveau mot de passe :</label>
                <input type="password" id="new-password" name="new-password" class="password-input" required>
                <br>
                <button type="submit">Valider</button>
            </form>
        </div>
    </div>

    <script>
        // Récupérer le bouton et les éléments du popup
        var modifierBtn = document.getElementById("modifier-btn");
        var popup = document.getElementById("popup");
        var closeBtn = document.getElementById("close-popup");

        // Afficher le popup lors du clic sur le bouton
        modifierBtn.addEventListener("click", function() {
            popup.style.display = "block";
        });

        // Fermer le popup lors du clic sur le bouton de fermeture
        closeBtn.addEventListener("click", function() {
            popup.style.display = "none";
        });

        // Fermer le popup lors du clic en dehors de celui-ci
        window.addEventListener("click", function(event) {
            if (event.target == popup) {
                popup.style.display = "none";
            }
        });
    </script>
</body>
</html>
