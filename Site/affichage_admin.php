<?php
session_start();
if(!isset($_SESSION["pseudo"]) || $_SESSION["statut"] != 1) {
    header('Location:index.php');
}
include 'bdd/connex.inc.php';
$pdo = connex();

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $pdo->query("DELETE FROM disponibilite WHERE id = ". $_GET['val']);
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
    <link rel="stylesheet" type="text/css" href="data/pagesAdmin.css">
</head>
<body>
    <?php
    include 'header.php';

    echo "<table>
        <tr> <th>Produit</th> <th>Couleur</th> <th>Description</th> <th>Prix</th> <th>Image</th> <th>Supprimer</th> <th>Modifier</th> <th>Stock</th> </tr>";

    $recup= $pdo->query('SELECT * FROM Produits');
    while ($donnees = $recup->fetch())
    {
        echo '<tr> <td>'; echo $donnees['type'] .'</td> ';
        echo '<td>'; echo $donnees['couleur'] . '</td> ';
        echo '<td>'; echo $donnees['description'] . '</td> ';
        echo '<td>'; echo $donnees['prix'] . '</td> ';
        echo '<td> <img src="data:image/jpeg;charset=utf8;base64,'. base64_encode($donnees['image']) .'" alt="" width="100" height="100"></img></td> ';
        echo '<td> <a href="affichage_admin.php?action=delete&val='.$donnees['id'].'" class="input_admin"> <input type="button" value="supprimer"> </a></td> ';
        echo '<td> <a href="admin_modification.php?val='.$donnees['id'].'"class="input_admin"> <input type="button" value="modifier"> </a></td> ';
        echo '<td> <a href="admin_stock.php?val='.$donnees['id'].'"class="input_admin"> <input type="button" value="voir le stock"> </a></td> </tr>';
    }
    echo '</table>';
    $recup->closeCursor();
    $pdo = null;
    ?>
</body>
</html>
