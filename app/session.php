<?php
// provider gestion des sessions
$app->register(new Silex\Provider\SessionServiceProvider());

//Variables sessions
$_SESSION['admin']=$app['session']->get('admin');
$_SESSION['connexion']=$app['session']->get('connexion');
$_SESSION['id']=$app['session']->get('id');
$_SESSION['rang']=$app['session']->get('rang');
$_SESSION['mdp']=$app['session']->get('mdp');
$_SESSION['level']=$app['session']->get('level');
$_SESSION['pseudo']=$app['session']->get('pseudo');
$_SESSION['password']=$app['session']->get('password');
$_SESSION['idtopic']=$app['session']->get('topic');
$_SESSION['nomtopic']=$app['session']->get('nomtopic');
$_SESSION['num_topic']=$app['session']->get('num_topic');
$_SESSION['avatar']=$app['session']->get('avatar');