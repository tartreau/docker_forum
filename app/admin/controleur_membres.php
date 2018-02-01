<?php

require("../src/modeles/modele_membre.php");
$membres = get_all_membres();


// Instanciation de la classe membre
require('../src/class/Membres.class.php');
require('../src/class/Connecte.class.php');
$membre = new Membres($dbCon);
$connecte = new Connecte($dbCon);

//Fonction suppression d'un membre de la zone admin
if (isset($num_membre)){
    $membre->delete_membre_by_id($num_membre);
    $connecte->delete_by_id($num_membre);
}