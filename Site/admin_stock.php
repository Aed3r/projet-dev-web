<!-- Cette page sers a visualiser sur un tableau les différentes tailles et en quelles quantités elles sont disponibles -->
<!-- On suppose que le stock est modifié automatiquement par les employés qui s'occupent des marchandises -->
<?php 
session_start();
if(!isset($_SESSION["pseudo"])) {
    header('Location:index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Stock disponible</title>
</head>
<body>
	<table>
		<tr>
			<th>Taille</th>
			<th>Quantité</th>
		</tr>
	<?php
		include 'bdd/connex.inc.php';
		$pdo = connex();
		$reponse= $pdo->query('SELECT * FROM disponibilite WHERE id = '. $_GET['val']);
		echo '<h1> Stock disponible pour ce t-shirt </h1>';
		while($donnee = $reponse->fetch()){
			echo '<tr>';
			echo '<td>'.$donnee['taille'].'</td>';
			echo '<td>'.$donnee['quantite'].'</td>';
			echo '</tr>';
		}
		$pdo = null;
	?>
	</table>
</body>
</html>