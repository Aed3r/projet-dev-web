<?php 
session_start();
if(!isset($_SESSION["pseudo"])) {
    header('Location:index.php');
}else if($_SESSION["status"] == 0){
    header('Location:index.php');
}
?>

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

if (!empty($_POST['type']) && !is_null($_POST['type'])) {
    $req1 = $pdo->prepare('UPDATE Produits SET type = :type WHERE id = :val');
    $req1->bindParam(':type', $_POST['type']);
    $req1->bindParam(':val', $_GET['val']);
    $req1->execute();
}

if (!empty($_POST['couleur'] && !is_null($_POST['couleur']))) {
    $req2 = $pdo->prepare('UPDATE Produits SET couleur = :couleur WHERE id = :val');
    $req2->bindParam(':couleur', $_POST['couleur']);
    $req2->bindParam(':val', $_GET['val']);
    $req2->execute();
}

if (!empty($_POST['description'] && !is_null($_POST['description']))) {
    $req3 = $pdo->prepare('UPDATE Produits SET description= :description WHERE id = :val');
    $req3->bindParam(':description', $_POST['description']);
    $req3->bindParam(':val', $_GET['val']);
    $req3->execute();
}

if (!empty($_POST['image'] && !is_null($_POST['image']))) {
    $req4 = $pdo->prepare('UPDATE Produits SET image=:image WHERE id = :val');
    $req->bindParam(':image', $img_blob, PDO::PARAM_LOB);
    $req4->bindParam(':val', $_GET['val']);
    $req4->execute();
}

if (!empty($_POST['prix'] && !is_null($_POST['prix']))) {
    $req5 = $pdo->prepare('UPDATE Produits SET prix= :prix WHERE id = :val');
    $req5->bindParam(':prix', $_POST['prix']);
    $req5->bindParam(':val', $_GET['val']);
    $req5->execute();
}

echo '<a href="affichage_admin.php"> retour </a>';

$pdo = null;
?>
</html>