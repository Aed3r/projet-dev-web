<!-- Cette page sers a visualiser sur un tableau les différentes tailles et en quelles quantités elles sont disponibles -->
<!-- On suppose que le stock est modifié automatiquement par les employés qui s'occupent des marchandises -->
<?php 
	session_start();
	if(!isset($_SESSION["pseudo"]) || !isset($_GET["val"]) || $_GET["val"] == null || $_GET["val"] == "" || $_SESSION["statut"] != 1) {
		header('Location:index.php');
	}

	include 'bdd/connex.inc.php';
	$pdo = connex();

	if (isset($_GET["delete"])) {
		$req = $pdo->prepare('DELETE FROM disponibilite WHERE id = :id AND taille = :t');
		$req->bindParam(':id', $_GET["val"]);
		$req->bindParam(':t', $_GET["delete"]);
		if ($req->execute() != TRUE) {
			echo "Erreur lors de la suppression de stock!";
		}
	}

	if (isset($_POST["taille"]) && $_POST["taille"] != null && $_POST["taille"] != "" && $_POST["quantite"] != null && $_POST["quantite"] != "") {
		$req = $pdo->prepare('INSERT INTO disponibilite(id, quantite, taille) VALUES (:id, :q, :t)');
		$req->bindParam(':id', $_GET["val"]);
		$req->bindParam(':q', $_POST["quantite"]);
		$req->bindParam(':t', $_POST["taille"]);
		if ($req->execute() != TRUE) {
			echo "Erreur lors de l'ajout de stock!";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Stock disponible</title>
	<link rel="stylesheet" type="text/css" href="data/pagesAdmin.css">
</head>
<body>
	<table>
		<tr>
			<th>Taille</th>
			<th>Quantité</th>
		</tr>
	<?php
		$reponse= $pdo->query('SELECT * FROM disponibilite WHERE id = '. $_GET['val']);
		echo '<h1> Stock disponible pour ce t-shirt </h1>';
		while($donnee = $reponse->fetch()){
			echo '<tr>';
			echo '<td>'.$donnee['taille'].'</td>';
			echo '<td>'.$donnee['quantite'].'</td>';
			echo '<td> <a href="admin_stock.php?delete='.$donnee['taille'].'&val='.$_GET["val"].'"> <input type="button" value="supprimer"> </a></td> ';
			echo '</tr>';
		}
		echo "</table>";
		$reponse->closeCursor();
		$pdo = null;
	
	echo "<form action='admin_stock.php?val=". $_GET['val'] ."' method='post'>"
	?>
		<label for="tailleIn">Taille:</label>
		<input type="text" id="tailleIn" name="taille">
		<label for="quantIn">Quantité:</label>
		<input type="text" id="quantIn" name="quantite">
		<input type="submit" value="Ajouter le stock">
	</form>
	<br>
	<a href="affichage_admin.php"> <input type="button" value="< Retour"> </a>
	</table>
</body>
</html>