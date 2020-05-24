<?php
session_start();
include 'bdd/connex.inc.php';
$pdo = connex();
?>
<!DOCTYPE html>
<html>
<head>
	<title>MonTshirt.fr/boutique</title>
	<meta charset="utf-8">
	<link rel="icon" href="data/img/iconne_site.png">
    <link rel="stylesheet" href="data/general_style.css"> 
</head>
<body>
	<?php
	include 'header.php';
	//echo $_GET['var'];

	$reponse= $pdo->query('SELECT * FROM Produits WHERE id = '.$_GET['var'].'');

	while ($donnees = $reponse->fetch())
	{
	    echo '<img src="data:image/jpeg;charset=utf8;base64,' . base64_encode($donnees['image']) . '" width="300" height="250" /> <br>';
	    echo '<strong>Produit : </strong>'; echo $donnees['type'] . '<br />';
	    echo '<strong>Couleur : </strong>'; echo $donnees['couleur'] . '<br />';
	    echo '<strong>Description : </strong>'; echo $donnees['description'] . '<br />';
	    echo '<strong>Prix : </strong>'; echo $donnees['prix'] . '€<br />';
	}

	$reponse->closeCursor();
	echo '<a href="boutique_client.php"> retour </a>';
	$pdo = null;
	?>
</body>
</html>