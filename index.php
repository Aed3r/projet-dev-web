<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
    </style>
</head>
<body>
<?php
if(!isset($_SESSION["pseudo"])) {
    echo "<h3>Vous n'êtes pas connecté(e)</h3><br>";
    echo "<a href='inscription.php'>S'inscrire</a><br>";
    echo "<a href='connexion.php'>Se connecter</a>";
} else {
    header('Location:creator.php');
}
?>

</body>
</html>