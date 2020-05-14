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
ini_set('display_errors', '1'); 
error_reporting(E_ALL);
try {
    $pdo = new PDO('mysql:host=localhost;dbname=projet', 'paul-antoine', 'passBD');
    }
catch(PDOException $e) {
echo $e->getMessage();
}

if (!empty($_POST['type'])) {
    echo 'TEST';
    $req1 = $pdo->prepare('UPDATE Produits SET type = :type WHERE lien_image = :val');
    $req1->bindParam(':type', $_POST['type']);
    $req1->bindParam(':val', $_GET['val']);
    $req1->execute();
}

if (!empty($_POST['couleur'])) {
    $req2 = $pdo->prepare('UPDATE Produits SET couleur = :couleur WHERE lien_image = :val');
    $req2->bindParam(':couleur', $_POST['couleur']);
    $req2->bindParam(':val', $_GET['val']);
    $req2->execute();
}

if (!empty($_POST['description'])) {
    $req3 = $pdo->prepare('UPDATE Produits SET description= :description WHERE lien_image = :val');
    $req3->bindParam(':description', $_POST['description']);
    $req3->bindParam(':val', $_GET['val']);
    $req3->execute();
}

if (!empty($_POST['lien_image'])) {
    $req4 = $pdo->prepare('UPDATE Produits SET lien_image= :lien WHERE lien_image = :val');
    $req4->bindParam(':lien', $_POST['lien_image']);
    $req4->bindParam(':val', $_GET['val']);
    $req4->execute();
}

echo '<a href="affichage_admin.php"> retour </a>';

$pdo = null;
?>
</html>