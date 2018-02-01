<?php

/******
*******
* VARIABLES SESSION
*******
*******/

$pseudo = $app['session']->get('pseudo');
$message_avatar = $app['session']->get('avatar');

// Variable affichant le pseudo de la personne connectee
if(isset($pseudo))
    $personnes_connectes="Utilisateur connecté : ".$pseudo;
else
	$personnes_connectes="";


$titre="Messages";
$titreforum=$app['session']->get('nomtopic');


// Recuperation des variables presentes dans l'url
$app['session']->set('sujet', $message_id);
$app['session']->set('topic', $membre_id);



/******
*******
* FONCTION MESSAGES/BDD
*******
*******/
// Fonction retournant les messages en fonction de l'id du topic
require('../src/modeles/modele_messages.php');
$lesmessages = get_all_messages();

// Fonction retournant un topic en fonction de l'id
// On a besoin pour afficher le titre du sujet
require('../src/modeles/modele_topic.php');
$letopic = get_topic_id($app['session']->get('topic'));

// Instanciation de la classe message
require('../src/class/Messages.class.php');
$message = new Messages($dbCon);


//Fonction insert message
if (isset($request)){
	$message->insert($request->get('message_contenu'),$pseudo,$message_avatar,date('H\hi \l\e d/M/Y'),$app['session']->get('sujet'),$app['session']->get('topic'),$_SESSION['id']);
}

//Fonction suppression de message
if (isset($request)){
	if (isset($num_message)){
		$message->delete($num_message);
	}
}

