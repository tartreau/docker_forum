<?php

function get_all_membres(){
	// Instancie d'une nouvelle connexion
	$db =new Db();
	// J'établie la connexion.
	$dbCon =$db->get();

    $sql="SELECT * from forum_membres";
    if(!$dbCon->query($sql))
	    echo "Pb d'accès à la base";
    else{
      $membres=Array();
      foreach ($dbCon->query($sql) as $row)
        $membres[]=$row;
    }

    //Clos la connexion
    $dbCon =$db->close();
  return $membres;
}

function get_all_membres_links(){
  // Instancie d'une nouvelle connexion
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $membres=Array();

  $sql="SELECT * from forum_membres";
  $stmt=$dbCon->query($sql);

  while($data=$stmt->fetch(PDO::FETCH_ASSOC)){
    $res=Array();
    $res['membre_pseudo'] = $data['membre_pseudo'];
    $res['membre_email'] = $data['membre_email'];
    $res['membre_siteweb'] = $data['membre_siteweb'];
    $res['membre_description'] = $data['membre_description'];
    $res['membre_localisation'] = $data['membre_localisation'];
    $res['membre_inscrit'] = $data['membre_inscrit'];
    $res['membre_derniere_visite']= $data['membre_derniere_visite'];
    $res['membre_rang'] = $data['membre_rang'];
    $res['URL']=$_SERVER["REQUEST_SCHEME"].'://'.
        $_SERVER['HTTP_HOST'].
        $_SERVER['CONTEXT_PREFIX'].
        '/forum_silex/www/api/membres/'.$data['membre_pseudo'];
    $membres[]=$res;
  }
  //Clos la connexion
  $dbCon =$db->close();
  return $membres;
}

function get_id_by_pseudo($membre_pseudo){
  // Instancie d'une nouvelle connexion
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="SELECT * from forum_membres where `membre_pseudo`=:membre_pseudo";
  $stmt=$dbCon->prepare($sql);
  $stmt->bindParam(':membre_pseudo', $membre_pseudo, PDO::PARAM_STR);
  $stmt->execute();

  $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
  //Clos la connexion
  $dbCon =$db->close();
  return $data[0];
}

function get_membre_by_pseudo($membre_pseudo){
  // Instancie d'une nouvelle connexion
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="SELECT * from forum_membres where `membre_pseudo`=:membre_pseudo";
  $stmt=$dbCon->prepare($sql);
  $stmt->bindParam(':membre_pseudo', $membre_pseudo, PDO::PARAM_STR);
  $stmt->execute();

  $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
  //Clos la connexion
  $dbCon =$db->close();
  return $data;
}

function get_membre_by_mail($email){
  // Instancie d'une nouvelle connexion
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="SELECT * FROM forum_membres WHERE membre_email =:mail";
  $stmt=$dbCon->prepare($sql);
  $stmt->bindValue(':mail',$email, PDO::PARAM_STR);
  $stmt->execute();

  $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
  //Clos la connexion
  $dbCon =$db->close();
  return $data;
}

function get_membre_by_id($membre_id){
  // Instancie d'une nouvelle connexion
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="SELECT * FROM forum_membres WHERE membre_id =:membre_id";
  $stmt=$dbCon->prepare($sql);
  $stmt->bindValue(':membre_id',$membre_id, PDO::PARAM_INT);
  $stmt->execute();

  $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
  //Clos la connexion
  $dbCon =$db->close();
  return $data[0];
}

function delete_membre_by_pseudo($membre_pseudo)
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="DELETE FROM forum_membres WHERE membre_pseudo =:membre_pseudo";
  $stmt=$dbCon->prepare($sql);
  $stmt->bindParam(':membre_pseudo', $membre_pseudo, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_OBJ);
}

function add_membre($data_2)
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();
    
  $data=$data_2[0]; 

  $sql="INSERT INTO `forum_membres`
      (`membre_pseudo`,`membre_mdp`,`membre_email`,`membre_siteweb`,`membre_avatar`,`membre_description`,`membre_localisation`,`membre_inscrit`,`membre_derniere_visite`) 
      values
      (?,?,?,?,?,?,?,?,?)";
  $stmt=$dbCon->prepare($sql);
  return $stmt->execute(array($data['membre_pseudo'], $data['membre_mdp'], $data['membre_email'],$data['membre_siteweb'],$data['membre_avatar'], $data['membre_description'], $data['membre_localisation'],$data['membre_inscrit'],$data['membre_derniere_visite']));
}