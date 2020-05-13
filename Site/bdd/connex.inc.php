<?php
function connex(){
  ini_set('display_errors', '1');
  error_reporting(E_ALL);
  include_once("param.inc.php");
  try {
      $pdo = new PDO('mysql:host='.HOTE.';dbname='.BDD, UTILISATEUR, PASSE);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(PDOException $e) {
      echo 'Problème à la connexion: '.$e->getMessage();
      die();
  }

  return $pdo;
}
?>