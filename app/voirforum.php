<?php

/******
*******
* VARIABLES SESSION
*******
*******/

// Enregistrement dans la variable session l'id du topic
$app['session']->set('topic', $membre_id);

// Getter du nom du membre
$pseudo = $app['session']->get('pseudo');

// Variable affichant le pseudo de la personne connectee
if(isset($pseudo))
    $personnes_connectes="Utilisateur connecté : ".$pseudo;
else
	$personnes_connectes="";

$titre="Topic";
$titreforum="temporaire";


/******
*******
* FONCTION TOPIC/BDD
*******
*******/
// Fonction retournant un topic en fonction de l'id
require('../src/modeles/modele_topic.php');
$letopic = get_topic_id($app['session']->get('topic'));
$n_topic = get_topic_nom($app['session']->get('topic'));
//Boucle pour récupérer le nom du topic qui se trouve dans la requete n_topic
foreach ($n_topic[0] as $cle=>$nom_t)
	$nomtopic=$nom_t;

//Enregistrement dans la variable du nom du topic
$app['session']->set('nomtopic', $nomtopic);

// Instanciation de la classe topic
require('../src/class/Topic.class.php');
$topic = new Topic($dbCon);

if(isset($request)){
	//Fonction insert de la classe topic pour permettre l'insertion d'un nouveau topic
	$app['session']->set('nomtopic', $nomtopic);
	$topic->insert($app['session']->get('topic'),$request->get('topic_titre'),$app['session']->get('pseudo'),0,date('H\hi \l\e d/M/Y'),"non déterminé",0,0,0,$app['session']->get('id'));
}

//Fonction suppression de la classe topic
if (isset($request)){
	if (isset($num_topic)){
		$topic->delete($num_topic);
	}
}