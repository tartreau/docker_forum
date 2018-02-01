<?php

/***************
****************
****** INCLUDE ET CONNEXION BDD
****************
****************/

	include("includes/identifiants.php");
	include("includes/functions.php");
	include("includes/constants.php");

    //Connexion à la bdd
	require("class/Db.class.php");

	//Connexion à la base de donnée
    try{
	    // Instancie d'une nouvelle connexion
		$db =new Db();
		// J'établie la connexion.
		$dbCon =$db->get();
	}
	catch (Exception $e) // en cas d'erreurs
	{
  		die('ERROR connexion: ' . $e->getMessage());
	}

	//Attribution des variables de session
	$lvl=(!empty($_SESSION['level']))?(int) $_SESSION['level']:1;
	$id=(!empty($_SESSION['id']))?(int) $_SESSION['id']:0;
	$pseudo=(!empty($_SESSION['pseudo']))?$_SESSION['pseudo']:'';
	