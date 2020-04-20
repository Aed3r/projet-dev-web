<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Title</title>
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
                echo "Vous ne pouvez pas vous connecter si vous l'êtes déjà.<br>";
            } else {
                if (!isset($_POST["pseudo"])) {
                    afficherFormulaire(null);
                } else {
                    $pseudo = $_POST["pseudo"];
                    $mdp = $_POST["mdp"];
                    $crypt = md5($mdp);
                    if(file_exists('membres.txt')) {
                        $lignes=file("membres.txt");
                        $found = 0;
                        foreach ($lignes as $num => $val) {
                            $res = explode(";", $val);
                            if (strcmp($res[0], $pseudo) == 0) {
                                if (strcmp($res[1], $crypt) == 0) {
                                    $found = 1;
                                    $_SESSION["pseudo"] = $res[0];
                                    $_SESSION["status"] = $res[2];
                                    header('Location:index.php');
                                }
                            }
                        }
                        if (!$found) {
                            afficherFormulaire("Erreur de pseudo ou de mot de passe");
                        }
                    } else {
                        echo "Erreur d'accès au fichier";
                    }
                }
            }
        ?>
    </body>
</html> 