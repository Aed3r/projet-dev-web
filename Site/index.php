<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
    </style>
</head>
<body>
	<nav>
		<a href='index.php'><img src='data/img/iconne_site.png' alt='iconne_site' height='100'></a><br>
		<?php
		if(!isset($_SESSION["pseudo"])) {
		    echo "<h3>Vous n'êtes pas connecté(e)</h3><br>";
		    echo "<a href='Site/inscription.php'>S'inscrire</a><br>";
		    echo "<a href='Site/connexion.php'>Se connecter</a>";
		} else {
			if($_SESSION["statut"] == 1){
				echo "<a href='affichage_admin.php'>Affichage boutique (admin)</a><br>";
				echo "<a href='ajout_boutique.php'>Ajout boutique (admin)</a><br>";
			}
			echo "<a href='creator.php'>Creer son t-shit personalisé</a><br>";
			echo "<a href='boutique_client.php'>boutique</a><br>";
		    echo "<a href='logout.php'>Se deconnecter</a><br>";
		}
		?>
	</nav>
</body>
</html>