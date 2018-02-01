<?php

// récuperation du contenu de la requete
$data=$requete['0'];

if ($data['membre_mdp'] == md5($password)) // Acces OK !
{
  //setters sessions
  $app['session']->set('pseudo', $pseudo);
  $app['session']->set('password', $password);
  $app['session']->set('avatar', $data['membre_avatar']);
  $app['session']->set('mdp', $data['membre_mdp']);
  $app['session']->set('connexion', true);
  $app['session']->set('id', $data['membre_id']);
  $app['session']->set('rang', $data['membre_rang']);

  if($data['membre_rang']==4){
    $app['session']->set('admin', true);
  }else{
    $app['session']->set('admin', false);
  }
  $app['session']->set('pseudo', $data['membre_pseudo']);
	
  date_default_timezone_set("Europe/Paris");

	$derniereCo = date('Y-m-d');
	$sqlLastCo = $dbCon->prepare("UPDATE `forum_membres`
													SET `membre_derniere_visite` = :membre_derniere_visite
													WHERE `forum_membres`.`membre_id` = :membre_id");

	$sqlLastCo->bindValue(':membre_id', $data['membre_id'], PDO::PARAM_STR);
	$sqlLastCo->bindValue(':membre_derniere_visite', $derniereCo, PDO::PARAM_STR);
	$sqlLastCo->execute();

  //On ajoute la personne dans la table des connectés
  require('../src/class/Connecte.class.php');
  $connect = new Connecte($dbCon);
  $connect->insert($app['session']->get('id'),$pseudo);
}else{
  $err='2';
}