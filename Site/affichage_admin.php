<?php
session_start();
if(!isset($_SESSION["pseudo"])) {
    header('Location:index.php');
}
include 'bdd/connex.inc.php';
$pdo = connex();

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $pdo->query("DELETE FROM disponibilité WHERE id = ". $_GET['val']);
    $sql = $pdo->prepare("DELETE FROM Produits WHERE id = :val ");
    $val = $_GET['val'];
    $sql->bindParam(':val', $val);
    $sql->execute();
  }
?>
<!DOCTYPE html>
<html>
<head>
    <title>MonTshirt.fr</title>
    <meta charset="utf-8">
    <link rel="icon" href="data/img/iconne_site.png">
    <link rel="stylesheet" href="data/general_style.css"> 
</head>
<body>
    <?php
    include 'header.php';
    $recup= $pdo->query('SELECT * FROM Produits');
    while ($donnees = $recup->fetch())
    {
        echo '<strong>Produit : </strong>'; echo $donnees['type'] .'        ';
        echo '<strong>Couleur : </strong>'; echo $donnees['couleur'] . '        ';
        echo '<strong>Description : </strong>'; echo $donnees['description'] . '        ';
        echo '<strong>prix : </strong>'; echo $donnees['prix'] . '        ';
        echo '<img src="data:image/jpeg;charset=utf8;base64,'. base64_encode($donnees['image']) .'" width="100" height="100" >';
        echo '<a href="affichage_admin.php?action=delete&val='.$donnees['id'].'" class="input_admin"> <input type="button" value="supprimer"> </a>';
        echo '<a href="admin_modification.php?val='.$donnees['id'].'"class="input_admin"> <input type="button" value="modifier"> </a> ';
        echo '<a href="admin_stock.php?val='.$donnees['id'].'"class="input_admin"> <input type="button" value="voir le stock"> </a> <br>';
    }

    $pdo = null;
    ?>
</body>
</html>
