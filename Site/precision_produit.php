<?php

//echo $_GET['var'];

ini_set('display_errors', '1');
error_reporting(E_ALL);
try {
    $pdo = new PDO('mysql:host=localhost;dbname=projet', 'paul-antoine', 'passBD');
    }
catch(PDOException $e) {
echo $e->getMessage();
}

$reponse= $pdo->query('SELECT * FROM Produits WHERE id = '.$_GET['var'].'');

while ($donnees = $reponse->fetch())
{
    echo '<img src='.$donnees['lien_image'].' width="300" height="250" /> <br> </a>';
    echo '<strong>Produit : </strong>'; echo $donnees['type'] . '<br />';
    echo '<strong>Couleur : </strong>'; echo $donnees['couleur'] . '<br />';
    echo '<strong>Description : </strong>'; echo $donnees['description'] . '<br />';
}

$reponse->closeCursor();
echo '<a href="boutique_client.php"> retour </a>';
$pdo = null;

?>