<?php
    function alert($message) {
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    session_start();

    $dirPath = "data/users/" . $_SESSION["pseudo"];

    if(isset($_POST["submit"])) {
        $file = uniqid($dirPath . "/");
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            alert("Le fichier est trop grand !");
        } else {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
                alert("Erreur lors de la mise en ligne du fichier : " . $_FILES["image"]["error"]);
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Créateur intéractif</title>
        <style>
            form.inline {
                display:inline-flex;
                margin:5px;
                padding:0px;
                justify-content: center;
                align-items: center;
            }
            form.inline input  {
                padding: 8px 15px;
                background-color: green;
                border: 1px solid #ddd;
                color: white;
                margin: 0px 10px;
            }
            form.inline input:hover  {
                background-color: darkgreen;
            }
        </style>
    </head>
    <body>
    <?php
        if(!isset($_SESSION["pseudo"])) {
            header('Location:index.php');
        } else {
            if (is_dir($dirPath)) {
                # On récupère les images déjà chargé
                $dir = new DirectoryIterator($dirPath);
                foreach ($dir as $file) {
                    if (!$file->isDot()) {
                        echo "<img src='". $file->getPathname() ."' alt='img' height='50'>";
                    }
                }
            } else {
                # L'utilisateur n'a jamais mis en ligne des images
                mkdir($dirPath);
            }
            echo 
" 
<form class='inline' action='creator.php' method='post' enctype='multipart/form-data'>
    <label for='image'>
        <input type='file' name='image' id='image' style='display:none;'/>
        <img src='data/img/plus.svg' alt='img' height='50'>
    </label>
    <input type='submit' value='Upload' name='submit'>
</form>
<br>";
        }
    ?>
    <br>
    <a href='logout.php'>Se déconnecter</a><br>
    </body>
</html>