<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>MonTshirt.fr</title>
	<meta charset="utf-8">
	<link rel="icon" href="data/img/iconne_site.png">
	<link rel="stylesheet" href="data/general_style.css"> 
	<link rel="stylesheet" href="data/indexStyle.css"> 
</head>
<body>
	<!-- On include le fichier qui contient le header car il est identique sur toutes les pages -->
	<?php include 'header.php'?>

	<div id="main">
		<div id="boutique">
			<img src="data/img/boutique.png">
			<div>
				<article>
				Ce site internet vous premetra de choisir parmis une grande variété de t-shirts répondant à tous vos désirs.<br>
				</article>
				<br>
				<a href="boutique_client.php"> <input type="button" value="Vers la boutique"> </a>
			</div>
		</div>
		<br>
		<div id="createur">
			<div>
				<article>
				Si votre soif de personnalisation est plus grande que notre catalogue,<br> 
				un créateur interactif de T-shirt est également disponible.<br> 
				Nous vous garantissons que personne ne jugera vos goûts artistique.
				</article>
				<br>
				<a href="creator.php"> <input type="button" value="Vers le créateur"> </a>
			</div>
			<img src="data/img/createur.png">
		</div>
	</div>
</body>
</html>