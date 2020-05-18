<?php
    try
    {
        /*Preparation de la requete*/
        $reponse = $bdd->prepare('SELECT img_name, img_type, img_blob FROM images WHERE img_name =:name');
        $reponse->bindValue(':name',$_GET['name']);
        /*Execution de la requete*/
        $reponse->execute();
        $donnees = $reponse->fetch();
        /* on ferme la connexion */
        $reponse->closeCursor();
    }
    catch(EXCEPTION $e)
    {  
        /* on affiche les erreur éventuelles en développement */
        die('Erreur : '.$e->getMessage());
    }
    header('Content-Type:'.$donnees['img_type']);
    echo $donnees['img_blob'];
?>