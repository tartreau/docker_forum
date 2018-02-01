<?php

/******
*******
* VARIABLES  - V.SESSION
*******
*******/

$titre = "Profil";
$id = $app['session']->get('id');

/******
*******
* FONCTIONS
*******
*******/


// Requete tableau membre 
require('../src/modeles/modele_membre.php');

// Recherche par pseudo ou identifiant en fonction de ce que l'on trouve dans l'url
if($num_profil[0]=='0'||$num_profil[0]=='1'||$num_profil[0]=='2'||$num_profil[0]=='3'||$num_profil[0]=='4'||$num_profil[0]=='5'||$num_profil[0]=='6'||$num_profil[0]=='7'||$num_profil[0]=='8'||$num_profil[0]=='9')
	$membre = get_membre_by_id($num_profil);
else
	$membre = get_id_by_pseudo($num_profil);

/******
*******
* VARIABLES (pour twig)
*******
*******/

$membre_id = $membre['membre_id'];
$membre_pseudo = $membre['membre_pseudo'];
$membre_mdp = $membre['membre_mdp'];
$membre_email = $membre['membre_email'];
$membre_siteweb = $membre['membre_siteweb'];
$membre_avatar = $membre['membre_avatar'];
$membre_description = $membre['membre_description'];
$membre_localisation = $membre['membre_localisation'];
$membre_inscrit = $membre['membre_inscrit'];
$membre_derniere_visite = $membre['membre_derniere_visite'];

$membre_rang = $membre['membre_rang'];
if($membre_rang == 1){
	$membre_rang = "Visiteur";
}
elseif ($membre_rang == 2){
	$membre_rang = "Membre";
}
elseif ($membre_rang == 3){
	$membre_rang = "Modérateur";
}
else {
	$membre_rang = "Administrateur";
}


// Instanciation de la classe membre
require('../src/class/Membres.class.php');
$membre = new Membres($dbCon);

//Fonction de modification membre
if (isset($request)){
	if ($app['session']->get('admin')==4){
		$membre->updateMembre($request->get('membre_id'),$request->get('membre_pseudo'),$request->get('membre_mdp'),$request->get('membre_email'),$request->get('membre_siteweb'), $request->get('membre_avatar'),$request->get('membre_description'),$request->get('membre_localisation'),$request->get('membre_inscrit'),$request->get('membre_derniere_visite'));
	}
}