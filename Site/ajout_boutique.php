<!Doctype html>
<html>

<form action="" method="post">
    <p>Type du produit : <input type="text" name="type" /></p>
    <p>Couleur du produit : <input type="text" name="couleur" /></p>
    <p>Description du produit : <input type="text" name="description" /></p>
    <p>Chemin bers le produit (depuis public-html) : <input type="text" name="lien_image" /></p>
    <p><input type="submit" value="OK"></p>
</form>

<?php
include 'bdd/connex.inc.php';
$pdo = connex();

if (isset($_POST['type'])) {
$req = $pdo->prepare('INSERT INTO Produits(type, couleur, description, lien_image) VALUES (:test, :test2, :test3, :test4)');

$req->bindParam(':test', $_POST['type']);
$req->bindParam(':test2', $_POST['couleur']);
$req->bindParam(':test3', $_POST['description']);
$req->bindParam(':test4', $_POST['lien_image']);

$req->execute();
var_dump($req->fetchAll());
}
echo '<a href="page_principale.html"> retour </a>';
$pdo = null;
?>
</html>