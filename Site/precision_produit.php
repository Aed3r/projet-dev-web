<?php

//echo $_GET['var'];

include 'bdd/connex.inc.php';
$pdo = connex();

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