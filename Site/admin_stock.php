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
		$req = $pdo->prepare('DELETE FROM disponibilite WHERE taille = :t');
		$req->bindParam(':t', $_GET["delete"]);
		if ($req->execute() != TRUE) {
			echo "<script>alert('Erreur lors de la suppression de stock!');</script>";
		}
	}

	if (isset($_POST["taille"]) && $_POST["taille"] != null && $_POST["taille"] != "" && $_POST["quantite"] != null && $_POST["quantite"] != "") {
		/*On regarde si on a pas déja des pieces dans cette taille la*/
		$test = $pdo->prepare('SELECT * FROM disponibilite WHERE taille LIKE :t AND id = :id');
		$test->bindParam(':id', $_GET["val"]);
		$test->bindParam(':t', $_POST["taille"]);
		$test->execute();
		if($test->rowCount() > 0){
			/*Si c'est le cas on fait un UPDATE et pas un INSERT*/
			$row = $test->fetch();
			$req = $pdo->prepare('UPDATE disponibilite SET quantite = :q WHERE id = :id AND taille LIKE :t');
			/*ON ajoute la nouvelle quantité a l'ancienne avant de changer la valeur de celle ci*/
			$newquantite = $_POST["quantite"] + $row['quantite'];
			$req->bindParam(':q', $newquantite); 
		}else{
			$req = $pdo->prepare('INSERT INTO disponibilite(id, quantite, taille) VALUES (:id, :q, :t)');
			$req->bindParam(':q', $_POST["quantite"]);
		}
		$req->bindParam(':id', $_GET["val"]);
		$req->bindParam(':t', $_POST["taille"]);
		if ($req->execute() != TRUE) {
			echo "<script>alert('Erreur lors de l'ajout de stock!');</script>";
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
	</table>
</body>
</html>