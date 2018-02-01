<?php

function get_all_connecte(){
    // Instancie d'une nouvelle connexion
    $db =new Db();
    // J'établie la connexion.
    $dbCon =$db->get();

	  // Fonction recherche de tous les personnes connectées
    $sql="SELECT * from forum_connecte";
    if(!$dbCon->query($sql))
	    echo "Pb d'accès à la base";
    else{
      $membres=Array();
      foreach ($dbCon->query($sql) as $row)
      {
        $membres[]=$row;
      }
    }

    //Clos la connexion
    $dbCon =$db->close();
  return $membres;
}