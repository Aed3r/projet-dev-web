<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
    td{
      border:1px solid black;
    }
    </style>
</head>
<body>
<?php
if(!isset($_SESSION["pseudo"])) {
    echo "<h3>Vous n'êtes pas connecté(e)</h3><br>";
    echo "<a href='inscription.php'>S'inscrire</a><br>";
    echo "<a href='connexion.php'>Se connecter</a>";
    echo "<br><br>";
    echo "Il faut être un(e) membre du site pour voir la liste des inscrits.";
} else {
    echo "<h3>Bonjour, " . $_SESSION["pseudo"] . ".</h3><br>";
    echo "<a href='logout.php'>Se déconnecter</a><br>";

    if(file_exists('membres.txt')){
        $lignes=file("membres.txt");
        echo "<table> </th> <th>Utilisateurs</th>";
        if ($_SESSION["status"] == 1) {
            echo " <th>Action</th> </tr>";
        }
        echo " </tr>";
        
        foreach ($lignes as $num => $val) {
            $res = explode(";", $val);
            $nom = $res[0];
            echo "<tr> </td> <td>" . $nom . "</td>";
            if ($_SESSION["status"] == 1) {
                echo " <td><a href='supprimer.php?user=" . $nom . "'>Supprimer</a></td>";
            }
            echo " </tr>";
        }
        echo "</table>";
    } else {
        echo "membres.txt n'existe pas!";
    }
}
?>

</body>
</html>