<?php
session_start();

include 'bdd/connex.inc.php';
$pdo = connex();

if (!isset($_GET['var']) || strlen($_GET['var']) > 4 || $_GET['var'] == null || $_GET['var'] == "") {
	header("Location:boutique_client.php");
}

/* Reduction du stock lors d'un achat */
if(isset($_GET['buy']) && isset($_POST['taille']) && $_POST['taille'] != null && $_POST['taille'] != "") {
	$req = $pdo->prepare('UPDATE disponibilite SET quantite = quantite - 1 WHERE id = :id AND taille = :t');
	$req->bindParam(':id', $_GET['var']);
	$req->bindParam(':t', $_POST['taille']);
	if ($req->execute() == TRUE) {
		header("Location:acheter.php");
	} else {
		echo "Cette taille n'existe pas!";
	}
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


	echo '<form action="precision_produit.php?var='.$_GET["var"].'&buy=1" method="post">';
		/*Menu déroulant pour choisir la taille*/
		echo '<label for="list">Taille :</label>';
		echo '<datalist id="list">';
		?>
			<select>
				<option>Veuillez choisir...</option>
				<?php 
					$rectaille = $pdo->query('SELECT taille FROM disponibilite WHERE id ='.$_GET["var"].' AND quantite > 0');
					while($dontaille = $rectaille->fetch()){
						echo '<option value="'.$dontaille['taille'].'">'.$dontaille['taille'].'</option>';
					}
				?>
			</select>
		</datalist>
		<?php echo '<input name="taille" id="inputTaille" list="list"> '; ?>
		<input type="submit" value="Acheter">
	</form>
	
	<br><br>
	<a href="boutique_client.php"> <input type="button" value="< Retour"> </a>
	<?php $pdo = null ?>
</body>
</html>