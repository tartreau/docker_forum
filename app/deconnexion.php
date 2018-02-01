<?php

if ($app['session']->get('id')==0)
	erreur(ERR_IS_NOT_CO);//si pas d'utilisateur connecté, on affiche l'erreur ERR_IS_NOT_CO
else {
	require('../src/class/Connecte.class.php');
	$connect = new Connecte($dbCon);
	$connect->delete($app['session']->get('password'));
	
	//Variables sessions
	$app['session']->set('admin', '');
	$app['session']->set('connexion', '');
	$app['session']->set('id', '');
	$app['session']->set('rang', '');
	$app['session']->set('mdp', '');
	$app['session']->set('level', '');
	$app['session']->set('pseudo', '');
	$app['session']->set('password', '');
}
