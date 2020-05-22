<?php
    try
    {
        /*Connexion a la bdd*/
        include 'bdd/connex.inc.php';
        $pdo = connex();
        /*Preparation de la requete*/
        $reponse = $pdo->prepare('SELECT image FROM images_util WHERE id =:identifiant');
        $reponse->bindValue(':identifiant',$_GET['id']);
        /*Execution de la requete*/
        $reponse->execute();
        $donnees = $reponse->fetch();
    }
    catch(EXCEPTION $e)
    {  
        /* on affiche les erreur éventuelles en développement */
        die('Erreur : '.$e->getMessage());
    }
    header("Content-type: " . $donnees['img_type']);
    echo $donnee['img_blob'];
    /* on ferme la connexion */
    $reponse->closeCursor();
    $pdo = NULL;
?>