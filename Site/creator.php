<!-- https://www.w3schools.com/html/html5_draganddrop.asp -->

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
            #div1, #div2 {
                float: left;
                width: 50px;
                height: 50px;
                margin: 10px;
                padding: 10px;
                border: 1px solid black;
            }
        </style>
        <script type="text/javascript">
            function allowDrop(ev){
                ev.preventDefault();
            }
            function drag(ev){
                ev.dataTransfer.setData("text", ev.target.id);
            }
            function drop(ev){
                ev.preventDefault();
                var data = ev.dataTransfer.getData("text");
                ev.target.appendChild(document.getElementById(data));
            }
        </script>
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
                        echo "<img src='". $file->getPathname() ."' alt='img' height='50' draggable='true'  ondragstart='drag(event)' id =". $file->getPathname() .">";
                    }
                }
            } else {
                # L'utilisateur n'a jamais mis en ligne des images
                mkdir($dirPath);
            }
            echo " 
<form class='inline' action='creator.php' method='post' enctype='multipart/form-data'>
    <label for='image'>
        <img src='data/img/plus.svg' draggable='true' ondragstart='drag(event)' id='drag1' alt='img' height='50'> <br>
        <input type='file' name='image' id='image'/>
    </label>
    <input type='submit' value='Upload' name='submit'>
</form>
<br>";
        }
    ?>
    <br>

    <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

    <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

    <br>
    <a href='logout.php'>Se déconnecter</a><br>
    </body>
</html>