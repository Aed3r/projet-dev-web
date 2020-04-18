<?php
    session_start();
    if (!isset($_SESSION["pseudo"]) | $_SESSION["status"] == 0) {
        echo "<h3>Vous n'avez pas accès à cette page</h3><br>";
        echo "<a href='index.php'>Retour à l'index</a>";
    } else {
        if (isset($_GET["user"])) {
            $pseudo = $_GET["user"];
            if(file_exists('membres.txt')) {
                $lignes=file("membres.txt");
                $found = 0;
                foreach ($lignes as $num => $val) {
                    $res = explode(";", $val);
                    if (strcmp($res[0], $pseudo) == 0) {
                        $found = 1;
                        file_put_contents("membres.txt", str_replace($val, "", file_get_contents("membres.txt")));
                        echo "<h3>Le membre \"" . $res[0] . "\" a bien été supprimé</h3><br>";
                        echo "<a href='index.php'>Retour à l'index</a>";
                    }
                }
                if (!$found) {
                    echo "<h3>Utilisateur invalide</h3><br>";
                    echo "<a href='index.php'>Retour à l'index</a>";
                }
            } else {
                echo "Erreur d'accès au fichier";
            }
        } else {
            echo "<h3>Rien à faire</h3><br>";
            echo "<a href='index.php'>Retour à l'index</a>";
        }
    }
?>