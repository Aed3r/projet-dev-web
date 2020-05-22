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
	$recup= $pdo->query('SELECT * FROM Produits');
	while ($donnees = $recup->fetch())
	{
	    echo '<a href="precision_produit.php?var= '.$donnees['id'].'" class="t-shirt"><img src="' . $donnees['lien_image'] . '" width="300" height="250" ></a>';
	}


	//echo '<img src="' . $lien . '" width="300" height="250" >';
	//echo  '<img src = "Images/iron_maiden.jpg"/>';

	//echo '<a href="1st_tshirt.php"> <img src="Images/iron_maiden.jpg" width="300" height="250" /> </a>';
	//echo '<img src="Images/metallica_basique.jpg" width="300" height="250" /></div> ';
	//echo '<img src="Images/t-shirt-chirac-thug-life_noir.jpg" width="250" height="300" /></div> ';

	function test() {
	    echo 'bonjour';
	}

	//echo '<a href="precision_produit.php?var=pierre">Lien pierre</a>';

	?>
</body>
</html>

