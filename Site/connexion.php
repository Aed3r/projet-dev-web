<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Connexion</title>
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
                if (!isset($_POST["pseudo"])) {
                    afficherFormulaire(null);
                } else {
                    include 'bdd/connex.inc.php';
                    $pdo = connex();
                    try{     
                        $pseudo=trim($_POST['pseudo']);
                        $mdp=md5(trim($_POST['mdp']));
                        
                        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo AND mdp = :mdp");
                        
                        $stmt->bindParam(':pseudo', $pseudo);
                        $stmt->bindParam(':mdp', $mdp);
                        
                        $stmt->execute();
                        
                        $nb = $stmt->rowCount();
                        if($nb==1){
                            $_SESSION['pseudo']=$pseudo;
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $_SESSION['statut'] = intval($row['statut']);
                            header('Location:index.php');
                        }
                        else{
                            echo "<!DOCTYPE HTML>
                                    <html>
                                    <head>
                                    <meta charset=\"utf-8\" />
                                    <title>Connexion</title>
                                    </head>
                                    <body>";
                            afficherFormulaire("erreur de pseudo ou mdp");
                        }
                        $stmt -> closeCursor();
                        $pdo = null;
                            
                    }
                    catch(PDOException $e) {
                        echo '<p>Problème à l\'exécution</p>';
                        die();
                    }
                }
            }
        ?>
    </body>
</html> 