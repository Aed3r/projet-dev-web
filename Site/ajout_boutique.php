<!Doctype html>
<html>

<form action="ajout_boutique.php" method="post" enctype='multipart/form-data'>
    <p>Type du produit : <input type="text" name="type" /></p>
    <p>Couleur du produit : <input type="text" name="couleur" /></p>
    <p>Description du produit : <input type="text" name="description" /></p>
    <p>Image du produit : <input type="file" name="image" id="image" accept="image/*" /></p>
    <p>Prix du produit : <input type="text" name="prix" /></p>
    <p><input type="submit" value="OK"></p>
</form>

<?php
include 'bdd/connex.inc.php';
$pdo = connex();

if (isset($_POST['type'])) {
	$img_blob = file_get_contents($_FILES["image"]["tmp_name"]);
	$req = $pdo->prepare('INSERT INTO Produits(type, couleur, description, image, prix) VALUES (:type, :couleur, :description, :image, :prix)');

	$req->bindParam(':type', $_POST['type']);
	$req->bindParam(':couleur', $_POST['couleur']);
	$req->bindParam(':description', $_POST['description']);
	$req->bindParam(':image', $img_blob, PDO::PARAM_LOB);
	$req->bindParam(':prix', $_POST['prix']);

	$req->execute();
}
echo '<a href="index.php"> retour </a>';
$pdo = null;
?>
</html>