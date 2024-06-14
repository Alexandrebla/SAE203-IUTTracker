<?php
// Vérifie si le formulaire est soumis
if(isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $ID = htmlspecialchars($_POST['ID']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $mail = htmlspecialchars($_POST['mail']);
    $telephone = htmlspecialchars($_POST['télé']);
    $classe = htmlspecialchars($_POST['classe']);
    $login = htmlspecialchars($_POST['login']);
    $mdp = htmlspecialchars($_POST['mdp']);

    // Validation des données (à personnaliser selon vos besoins)
    // Vous pouvez vérifier par exemple si les champs obligatoires sont remplis,
    // si les emails sont valides, etc.
    // Database connection details
    $serveur = "mysql-hamonbrouillard.alwaysdata.net";
    $utilisateur = "362372";
    $motdepasse = "tructruc123*";
    $basededonnees = "hamonbrouillard_iuttracker";

    try {
        // Connecter à la base de données avec PDO
        $connexion = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête d'insertion
        $sql = "INSERT INTO Etudiant (Id_Etudiant, nom, prénom, mail_univ, téléphone, Id_Classe, login_etudiant, mdp_etudiant) VALUES (:ID, :nom, :prenom, :mail, :telephone, :classe, :login, :mdp)";
        
        // Préparation de la requête
        $stmt = $connexion->prepare($sql);
        
        // Liaison des paramètres
        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':classe', $classe);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':mdp', $mdp);
        
        // Exécution de la requête
        $stmt->execute();
        
        echo "Étudiant ajouté avec succès.";

        // Redirection vers VuEleve.php
        header("Location: VuEleve.php");
        exit(); // Assure la fin de l'exécution du script après la redirection

    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
