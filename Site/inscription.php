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
    echo "Vous ne pouvez pas vous inscrire si vous êtes déjà connecté(e).<br>";
} else {
    if (isset($_POST["pseudo"])) {
        $pseudo = $_POST["pseudo"];
        $mdp = $_POST["mdp"];
        if(file_exists('membres.txt')) {
            $lignes=file("membres.txt");
            $found = 0;
            foreach ($lignes as $num => $val) {
                $res = explode(";", $val)[0];
                if (strcmp($res, $pseudo) == 0) {
                    afficherFormulaire("Ce pseudo est déjà utilisé");
                    $found = 1;
                }
            }
            if (!$found) {
                $crypt = md5($mdp);
                if($id_file=fopen("membres.txt","a")){ 
                    fwrite($id_file, $pseudo.";".$crypt.";0\n"); //ou fputs() : ce sont des alias
                    fclose($id_file);

                    echo "Inscription réussi ! <a href='connexion.php'>Connexion</a><br>";
                } else {
                    echo "Erreur d'accès au fichier";
                }
            }
        } else {
            echo "Erreur d'accès au fichier";
        }
    } else {
        afficherFormulaire(null);
    }
}
?>

</body>
</html> 