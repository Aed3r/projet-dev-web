<?php
session_start();
include 'bdd/connex.inc.php';
$pdo = connex();
if(isset($_POST["submit"])) {
	$recup = $pdo->query('SELECT * FROM Produits WHERE description LIKE "%' . $_POST["recherche"] .'%"');
}else{
	$recup = $pdo->query('SELECT * FROM Produits');
}
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
	?>
	<form class='search' action='boutique_client.php' method='post' enctype='multipart/form-data'>
        <label for="recherche">
        	<input type="text" name="recherche" id="recherche">
        </label>
        <input type='submit' value='search' name='submit'>
    </form> 
	<?php
	/*On fait un premier fetch pour voir si notre requête est vide*/
	$donnees = $recup->fetch();
	if(empty($donnees) && isset($_POST["submit"])){
		/*Si elle l'est on affiche un message d'erreur*/
		echo "Désolé mais aucun résultat n'a été trouvé pour la recherche :" . $_POST["recherche"];
	}else{
		/*Sinon on affiche le premier produit avant de lancer la boucle (Sinon on loupe le premier produit)*/
		echo '<a href="precision_produit.php?var= '.$donnees['id'].'" class="t-shirt"><img src="' . $donnees['lien_image'] . '" width="300" height="250" ></a>'.$donnees['prix'].'€';
	}
	while ($donnees = $recup->fetch())
	{
	    echo '<a href="precision_produit.php?var= '.$donnees['id'].'" class="t-shirt"><img src="' . $donnees['lien_image'] . '" width="300" height="250" ></a>'.$donnees['prix'].'€';
	}
	?>
</body>
</html>

