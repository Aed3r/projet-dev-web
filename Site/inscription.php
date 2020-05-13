<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8" />
            <title>Inscription</title>
    </head>
    <body>

<?php
function afficherFormulaire($p) {
    echo 
"<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">
    <label>Pseudo : <input type='text' name='pseudo' placeholder='".$p."' required></label><br>
    <label>Mot de passe : <input type='password' name='mdp' required></label><br>
    <input type='submit' value='Valider'/>
</form>";
}

if (isset($_SESSION["pseudo"])) {
    header('Location:index.php');
} else {
    if (isset($_POST["pseudo"])) {
        include 'bdd/connex.inc.php';
        $pdo = connex();
        try{     
            $pseudo=trim($_POST['pseudo']);
            
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
            
            $stmt->bindParam(':pseudo', $pseudo);
            
            $stmt->execute();
            
            $nb = $stmt->rowCount();
            if($nb==1){
                afficherFormulaire("Pseudo déjà utilisé!");
            }
            else{
                $stmt -> closeCursor();
                $mdp=md5(trim($_POST['mdp']));
                
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (pseudo, mdp, statut) VALUES( :pseudo, :mdp, '0')");
                
                $stmt->bindParam(':pseudo', $pseudo);
                $stmt->bindParam(':mdp', $mdp);
                
                $stmt->execute();
                
                $nb = $stmt->rowCount();
                if($nb == 1){
                    echo "Vous avez bien été inscrit.<br>";
                    echo "<a href='connexion.php'>Se connecter</a>";
                }
                else{
                    echo '<p>Erreur lors de l\'ajout</p>';
                    echo "<a href='index.php'>Index</a><br>";
                }
            }
            $stmt -> closeCursor();
            $pdo = null;
                
        }
        catch(PDOException $e) {
            echo '<p>Problème à l\'exécution</p>';
            die();
        }
    } else {
        afficherFormulaire(null);
    }
}
?>

</body>
</html> 