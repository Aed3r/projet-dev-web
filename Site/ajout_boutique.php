<!Doctype html>
<html>

<form action="" method="post">
    <p>Type du produit : <input type="text" name="type" /></p>
    <p>Couleur du produit : <input type="text" name="couleur" /></p>
    <p>Description du produit : <input type="text" name="description" /></p>
    <p>Chemin bers le produit (depuis public-html) : <input type="text" name="lien_image" /></p>
    <p>Prix du produit : <input type="text" name="prix" /></p>
    <p><input type="submit" value="OK"></p>
</form>

<?php
include 'bdd/connex.inc.php';
$pdo = connex();

if (isset($_POST['type'])) {
$req = $pdo->prepare('INSERT INTO Produits(type, couleur, description, lien_image, prix) VALUES (:type, :couleur, :description, :lien_image, :prix)');

$req->bindParam(':type', $_POST['type']);
$req->bindParam(':couleur', $_POST['couleur']);
$req->bindParam(':description', $_POST['description']);
$req->bindParam(':lien_image', $_POST['lien_image']);
$req->bindParam(':prix', $_POST['prix']);

$req->execute();
var_dump($req->fetchAll());
}
echo '<a href="index.php"> retour </a>';
$pdo = null;
?>
</html>