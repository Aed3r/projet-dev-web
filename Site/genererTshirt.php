<?php
    session_start();

    if(!isset($_SESSION["pseudo"])) {
        header('Location:index.php');
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    /*Connexion au sgbd*/
    include 'bdd/connex.inc.php';
    $pdo = connex();

    if (isset($_POST["img"])) {
        $imgb64 = $_POST['img'];
        $imgb64 = str_replace('data:image/png;base64,', '', $imgb64);
        $imgb64 = str_replace(' ', '+', $imgb64);
        $img_blob = base64_decode($imgb64);
        $req = $pdo->prepare('INSERT INTO Produits(type, couleur, description, image, prix) VALUES ("T-Shirt", :couleur, :description, :image, :prix)');

        $req->bindParam(':couleur', $_POST['color']);
        $req->bindParam(':description', $_POST['description']);
        $req->bindParam(':image', $img_blob, PDO::PARAM_LOB);
        $req->bindParam(':prix', $_POST['price']);

        if ($req->execute() == TRUE) {
            header("Location:boutique_client.php");
        } else {
            echo "<script>alert('Erreur lors de l'ajout d'un T-Shirt dans la boutique!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T-Shirt généré</title>
        <link rel="stylesheet" type="text/css" href="data/genShirt.css">
        <link rel="stylesheet" href="data/general_style.css"> 
        <link rel="icon" href="data/img/iconne_site.png">
        <script src="data/genShirt.js" type="text/javascript"></script>
    </head>

    <body>

    <!-- On inclus le fichier qui contient le header car il est identique sur toutes les pages -->
    <?php include 'header.php';

    /* Chargement des images liées à l'utilisateur */
    $req = $pdo->query("SELECT id, image FROM images WHERE username = '". $_SESSION['pseudo'] . "'");
    while($donnee = $req->fetch()){ 
        echo "<img src='data:image/jpeg;charset=utf8;base64," . base64_encode($donnee['image']) . "' class='hidden' id='". $donnee['id'] ."'/> ";
    }
    ?>

    <div id="main">
        <input type='button' value="< Retour à l'éditeur" id='backBTN' onClick="back()">
        <div id="canvasDiv"> <canvas id="canvas" width="100" height="100"> </canvas> </div>
        <div id='rightSidePanel'>
        <?php 
            if ($_SESSION['statut'] == 1) {
                echo "<form action='genererTshirt.php' method='post' id='adminForm'>
                        <input type='text' id='tmpData' name='img' class='hidden'>
                        <input type='text' id='colorInput' name='color' placeholder='Couleur du produit'><br>
                        <input type='number' id='priceInput' name='price' placeholder='Prix du produit'><br>
                        <textarea id='description' name='description' placeholder='Description du produit' onkeyup='countChar(this)' maxlength='60'></textarea>
                        <label for='description' id='countLbl'>0/60</label>
                        <br>
                        <input type='button' value='Ajouter à la boutique' onclick='toStore()'>
                    </form> <br>";
            } else {
                echo "<input type='button' value='Acheter >' id='buyBTN'>";
            }
        ?>
        </div>
    </div>

    <?php
        /* Deconnexion du sgbd */
        $pdo = NULL ; 
    ?>

    </body>

</html>