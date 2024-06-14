<?php
session_start(); // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['id_etudiant'])) {
    header('Location: ../index.php');
    exit();
}

$prenom = $_SESSION['prenom'];
$nom = $_SESSION['nom'];
$mail_univ = $_SESSION['mail_univ'];
$login_etudiant = $_SESSION['login_etudiant'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Etudiant</title>
    <link rel="stylesheet" href="../Css/Profils.css">
    <style>
        /* Insert the popup CSS here */
        .popup {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .popup-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
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
        width: 100%; /* Adjust the width as needed */
        max-width: 300px; /* You can adjust this value */
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
            <a href="Notes.php"><img src="../Images/Capture_d_écran_2024-05-17_121009-removebg-preview.png" alt="iuttracker"></a>
        </div>
        <div class="nav">
            <button class="nav-button"><a href="ProfilE.php"><img src="../Images/Profil.png" alt="profil">Profil</a></button>
            <button class="nav-button"><a href="Notes.php"><img src="../Images/Notes.png" alt="notes">Mes notes</a></button>
        </div>
        <form action="Déco.php" method="post">
            <div class="logout">
                <a href="../index.html"><button class="logout-button"><strong>Déconnexion</strong></button></a>
            </div>
        </form>
    </div>

    <main>
        <div class="container">
            <form action="Connexion_etudiant.php">
                <div class="user-profile">
                    <br>
                    <h1><?php echo htmlspecialchars($prenom . " " . $nom); ?></h1>
                    <p><em><?php echo htmlspecialchars($mail_univ); ?></em></p>
                    <img src="../Images/64ebb87451f23bdf0f809e128ff30e82.jpg" alt="Photo de profil">
                </div>
            </form>

            <div class="credentials">
                <label for="username">Identifiant :</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($login_etudiant); ?>">
                <br><br><br>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($mdp_etudiant); ?>">
                <br>
                <button class="btn" id="modifier-btn" type="button">Modifier</button>
            </div>
        </div>
    </main>

    <!-- The Popup -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" id="close-popup">&times;</span>
            <h2>Modifier le mot de passe</h2>
            <form action="modifier_mot_de_passe.php" method="post">
                <label for="new-password">Nouveau mot de passe :</label>
                <input type="password" id="new-password" name="new-password" class="password-input" required>
                <br>
                <button type="submit">Valider</button>
            </form>
        </div>
    </div>

    <script>
        // Get the button and popup elements
        var modifierBtn = document.getElementById("modifier-btn");
        var popup = document.getElementById("popup");
        var closeBtn = document.getElementById("close-popup");

        // Show the popup when the button is clicked
        modifierBtn.addEventListener("click", function() {
            popup.style.display = "block";
        });

        // Close the popup when the close button is clicked
        closeBtn.addEventListener("click", function() {
            popup.style.display = "none";
        });

        // Close the popup when the user clicks outside of it
        window.addEventListener("click", function(event) {
            if (event.target == popup) {
                popup.style.display = "none";
            }
        });
    </script>
</body>
</html>
