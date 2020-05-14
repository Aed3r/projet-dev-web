<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);
try {
    $pdo = new PDO('mysql:host=localhost;dbname=projet', 'paul-antoine', 'passBD');
    }
catch(PDOException $e) {
echo $e->getMessage();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $sql = $pdo->prepare("DELETE FROM Produits WHERE lien_image = :val ");
    $val = $_GET['val'];
    $sql->bindParam(':val', $val);
    $sql->execute();
  }

$recup= $pdo->query('SELECT * FROM Produits');
while ($donnees = $recup->fetch())
{
    echo '<strong>Produit : </strong>'; echo $donnees['type'] .'        ';
    echo '<strong>Couleur : </strong>'; echo $donnees['couleur'] . '        ';
    echo '<strong>Description : </strong>'; echo $donnees['description'] . '        ';
    echo '<img src="'.$donnees['lien_image'].'" width="100" height="100" >';
    echo '<a href="affichage_admin.php?action=delete&val='.$donnees['lien_image'].'"> supprimer </a>';
    echo '<a href="admin_modification.php?val='.$donnees['lien_image'].'"> modifier </a> <br>';
    
}

$pdo = null;
?>
