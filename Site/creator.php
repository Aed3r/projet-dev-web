<?php
    function alert($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    session_start();
    $max_size = 50000; /*Taille maximale des photos*/
    /*$dirPath = "data/users/" . $_SESSION["pseudo"];*/
    /*Gestion de l'upload de fichier*/
    /*Version fichiers classique*/
    /*if(isset($_POST["submit"])) {
        $file = uniqid($dirPath . "/");
        if ($_FILES["image"]["size"] > 500000) {
            alert("Le fichier est trop grand !");
        } else {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
                alert("Erreur lors de la mise en ligne du fichier : " . $_FILES["image"]["error"]);
            }
        }
        unset($_POST["submit"]);
    }*/
    /*Version bdd*/
    /*Connexion au sgbd*/
    include 'bdd/connex.inc.php';
    $pdo = connex();
    if(isset($_POST["submit"])) {
        if(!is_uploaded_file($_FILES["image"]["tmp_name"])){
            alert("Problème lors du transfert de l'image");
        }else{
            /*Le fichier a été reçu correctement*/
            if($_FILES["image"]["size"] > $max_size){
                alert("Votre fichier est trop volumineux");
            }else{
                /*Préparation de la requête*/
                $img_blob = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
                $req = $pdo->prepare('INSERT INTO images(username, image) VALUES (:pseudo, :image)');
                $req->bindParam(':pseudo', $_SESSION['pseudo']);
                $req->bindParam(':image', $img_blob);
                /*Exécution de la requête*/
                $req->execute();
            }
        }
    }
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
    <!-- On include le fichier qui contient le header car il est identique sur toutes les pages -->
    <?php include 'header.php'?>
    <div id="selector">
    <?php
        if(!isset($_SESSION["pseudo"])) {
            header('Location:index.php');
        } else {
            /*if (is_dir($dirPath)) {
                # On récupère les images déjà chargé
                $dir = new DirectoryIterator($dirPath);
                foreach ($dir as $file) {
                    if (!$file->isDot()) {
                        echo "<img src='". $file->getPathname() ."' alt='img' height='50' draggable='true' class='unselectable thumbnail' ondragstart='drag(event)' id =". basename($file->getPathname()) ."><br>";
                    }
                }
            } else {
                # L'utilisateur n'a jamais mis en ligne des images
                mkdir($dirPath);
            }*/
            /*On recupere les images de l'utilisateur*/
            $req = $pdo->query("SELECT id, image FROM images WHERE username = '". $_SESSION['pseudo'] . "'");
            while($donnee = $req->fetch()){ 
                /*echo "<img src='genere_image.php?id=".$donnee['id']."' height='50' draggable='true' class='unselectable thumbnail' ondragstart='drag(event)' id =". $donnee['id'] ."><br>";*/
                echo "<img src='data:image/png;charset=utf8;base64," . base64_encode($donnee['image']) . "' height='50' draggable='true' class='unselectable thumbnail' ondragstart='drag(event)' id =". $donnee['id'] ." /><br>";
            }
        }
    ?>
    <form class='inline' action='creator.php' method='post' enctype='multipart/form-data'>
        <label for='image'>
            <input type='file' name='image' id='image' style='display:none;' accept="image/*"/>
            <img src='data/img/plus.svg' alt='Ajouter une image' height='50'>
        </label>
        <input type='submit' value='Upload' name='submit'>
    </form> <br> <br>
    </div>
    
    <div id="creator" ondrop="drop(event)" ondragover="allowDrop(event)" onmousemove="resize(event)" onmouseleave="resizeStop()" onclick="handleClick(event)">
        <img src='data/img/tshirt-mask.svg' class="unselectable" id="mask" alt='mask'>
        <span class="handle" id="topleft" onmousedown="resizeStart('topleft')" onmouseup="resizeStop()"></span>
        <span class="handle" id="topright" onmousedown="resizeStart('topright')" onmouseup="resizeStop()"></span>
        <span class="handle" id="bottomleft" onmousedown="resizeStart('bottomleft')" onmouseup="resizeStop()"></span>
        <span class="handle" id="bottomright" onmousedown="resizeStart('bottomright')" onmouseup="resizeStop()"></span> 
        <img src='data/img/plus.svg' id="delBtn" alt='Supprimer' class="delBtn">
    </div>

    <br>
    <label for="colorWell">Couleur:</label>
    <input type="color" value="#ff0000" id="colorWell">
    <br>
    <a href='logout.php'>Se déconnecter</a><br>
    <!-- Deconnexion du sgbd -->
    <?php $pdo = NULL ; ?>
    </body>
</html>