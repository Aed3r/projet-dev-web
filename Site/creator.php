<?php
    session_start();

    if(!isset($_SESSION["pseudo"])) {
        header('Location:index.php');
    }

    /*Connexion au sgbd*/
    include 'bdd/connex.inc.php';
    $pdo = connex();

    function alert($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    $max_size = 5000000; /* Taille maximale des photos: 5 MB */

    /*Sauvegarde de l'image sur la bdd sous forme de blob (binaire)*/ 
    if(isset($_POST["submit"])) {
        if(!is_uploaded_file($_FILES["image"]["tmp_name"])){
            alert("Problème lors du transfert de l'image");
        }else{
            /*Le fichier a été reçu correctement*/
            if($_FILES["image"]["size"] > $max_size){
                alert("Votre fichier est trop volumineux");
            }else{
                /*Préparation de la requête*/
                $img_blob = file_get_contents($_FILES["image"]["tmp_name"]);
                $req = $pdo->prepare('INSERT INTO images(username, image) VALUES (:pseudo, :image)');
                $req->bindParam(':pseudo', $_SESSION['pseudo']);
                $req->bindParam(':image', $img_blob, PDO::PARAM_LOB);
                /*Exécution de la requête*/
                $req->execute();
            }
        }
    }

    $idImages = [];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Créateur intéractif</title>
        <link rel="stylesheet" type="text/css" href="data/creatorStyle.css">
        <link rel="stylesheet" href="data/general_style.css"> 
        <link rel="icon" href="data/img/iconne_site.png">
        <script src="data/creatorScript.js" type="text/javascript"></script>
    </head>

    <body>

    <!-- On inclus le fichier qui contient le header car il est identique sur toutes les pages -->
    <?php include 'header.php'?>
    
    <div id="main">

    <!-- Sélection d'images -->
    <div id="selector">

        <div id="scrollBox">
        <?php
            /* On recupere les images de l'utilisateur */
            $req = $pdo->query("SELECT id, image FROM images WHERE username = '". $_SESSION['pseudo'] . "'");
            while($donnee = $req->fetch()){ 
                echo "<img src='data:image/jpeg;charset=utf8;base64," . base64_encode($donnee['image']) . "' height='50' draggable='true' class='unselectable thumbnail' ondragstart='drag(event)' id='". $donnee['id'] ."s' name='". $donnee['id'] ."'/><br>";
                $idImages[] = $donnee['id'];
            }
            $req->closeCursor();
        ?>
        </div>
        <br>

        <form class='inline' action='creator.php' method='post' enctype='multipart/form-data'>
            <label for='image'>
                <input type='file' name='image' id='image' style='display:none;' accept="image/*"/>
                <img src='data/img/plus.svg' alt='Ajouter une image' height='50'>
            </label>
            <input type='submit' value='Upload' name='submit' id='submitBTN'>
        </form> 
        <br>

        <label for="colorWell">Couleur:</label>
        <input type="color" value="<?php 
            if (isset($_GET['c']) && $_GET['c'] !== "" && strlen($_GET['c']) == 7) {
                echo $_GET['c'];
            } else {
                echo '#f5f5f5';
            }
        ?>" id="colorWell">
        <br>
    
    </div>

    <!-- Créateur -->
    <div id="creator" ondrop="drop(event)" ondragover="allowDrop(event)" onmousemove="resize(event)" onmouseleave="resizeStop()" onclick="handleClick(event)">
        <img src='data/img/tshirt-mask.svg' class="unselectable" id="mask" alt='mask'>
        <span class="handle" id="topleft" onmousedown="resizeStart('topleft')" onmouseup="resizeStop()"></span>
        <span class="handle" id="topright" onmousedown="resizeStart('topright')" onmouseup="resizeStop()"></span>
        <span class="handle" id="bottomleft" onmousedown="resizeStart('bottomleft')" onmouseup="resizeStop()"></span>
        <span class="handle" id="bottomright" onmousedown="resizeStart('bottomright')" onmouseup="resizeStop()"></span> 
        <img src='data/img/plus.svg' id="delBtn" alt='Supprimer' class="delBtn unselectable">
        <?php 
            /* Recréation du T-Shirt à partir de l'URL */
            $charID = 'a';
            foreach ($idImages as $id) {
                if (isset($_GET[$id]) && is_array($_GET[$id])) {
                    foreach ($_GET[$id] as $arr) {
                        if (!is_string($arr)) break 1;

                        /* Coordonnées et dimensions de l'image */
                        $val = explode(" ", $arr);

                        /* Vérifications */
                        if (count($val) != 4 ) break 1;
                        foreach ($val as $tmp) if (!is_int($tmp)) break 1;

                        /* Source de l'image */
                        $req = $pdo->query("SELECT image FROM images WHERE id = '". $id . "'");
                        echo "<img id='".$charID."' class='unselectable used' src='data:image/jpeg;charset=utf8;base64,".base64_encode($req->fetch()['image'])."' draggable='true' ondragstart='drag(event)' name='".$id."' style='margin-left:".$val[0]."px; margin-top:".$val[1]."px; width:".$val[2]."px; height:".$val[3]."px;'/>";
                        $charID++;
                        $req->closeCursor();
                    }
                }
            }
        ?>
    </div>
    <input type='button' value='Générer >' id='generateBTN' onclick='genTshirt()'>
    </div>

    <?php 
        /* Deconnexion du sgbd */
        $pdo = NULL ; 
    ?>
    </body>
</html>