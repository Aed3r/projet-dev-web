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
	<title>MonTshirt.fr Boutique</title>
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
        	<input type="search" name="recherche" id="recherche">
        </label>
        <input type='submit' value='search' name='submit'>
    </form> 
	<?php
	while ($donnees = $recup->fetch())
	{
		echo '<div class="t-shirt-capsule">';
	    echo '<a href="precision_produit.php?var= '.$donnees['id'].'" class="t-shirt"><img src="data:image/jpeg;charset=utf8;base64,' . base64_encode($donnees['image']) . '" width="300" height="250" ></a><br>';
	    
	    echo '<label for="'.$donnees['id'].'">taille :</label>';
		echo '<datalist id="'.$donnees['id'].'">';
		?>
			<select name="taille">
				<option>Veuillez choisir...</option>
				<?php 
					$rectaille = $pdo->query('SELECT taille FROM disponibilité WHERE id ='.$donnees['id'].' AND quantité > 0');
					while($dontaille = $rectaille->fetch()){
						echo '<option value="'.$dontaille['taille'].'">'.$dontaille['taille'].'</option>';
					}
				?>
			</select>
		</datalist>
		<?php echo '<input name="input'.$donnees['id'].'" id="input'.$donnees['id'].'" list="'.$donnees['id'].'"> ';
		echo $donnees['prix'] . '€';
		echo '</div>';
	}
	?>
</body>
</html>