<?php

function get_all_messages(){
	 // Instancie d'une nouvelle connexion
	 $db =new Db();
	 // J'établie la connexion.
	 $dbCon =$db->get();

    $sql="SELECT * from forum_message Order by message_id";
    if(!$dbCon->query($sql))
	    echo "Pb d'accès à la base";
    else{
      $msg=Array();
      foreach ($dbCon->query($sql) as $row)
        $msg[]=$row;
    }

    //Clos la connexion
    $dbCon =$db->close();
  return $msg;
}

function get_all_messages_links(){
     // Instancie d'une nouvelle connexion
     $db =new Db();
     // J'établie la connexion.
     $dbCon =$db->get();

    $messages = Array();

    $sql="SELECT * from forum_message";
    $stmt=$dbCon->query($sql);

    while($data=$stmt->fetch(PDO::FETCH_ASSOC)){
        $res=Array();
        $res['message_contenu'] = $data['message_contenu'];
        $res['message_createur'] = $data['message_createur'];
        $res['message_time'] = $data['message_time'];
        $res['URL']=$_SERVER["REQUEST_SCHEME"].'://'.
        $_SERVER['HTTP_HOST'].
        $_SERVER['CONTEXT_PREFIX'].
        '/Projet_PHP/www/api/messages/'.$data['message_createur'];
    $messages[]=$res;
  }

    //Clos la connexion
    $dbCon =$db->close();
  return $messages;
}

function get_message_id($message_id){
    // Instancie d'une nouvelle connexion
    $db =new Db();
    // J'établie la connexion.
    $dbCon =$db->get();

    $sql="SELECT * from forum_message where message_id=:message_id";
    $data=$dbCon->prepare($sql);
    $data->bindParam(':message_id', $message_id, PDO::PARAM_INT);
    $data->execute();

    //Clos la connexion
    $dbCon =$db->close();
  return $data->fetchAll(PDO::FETCH_ASSOC);
}

function get_message_createur($message_createur){
      // Instancie d'une nouvelle connexion
    $db =new Db();
    // J'établie la connexion.
    $dbCon =$db->get();

    $sql="SELECT * from forum_message where message_createur=:message_createur";
    $data=$dbCon->prepare($sql);
    $data->bindParam(':message_createur', $message_createur, PDO::PARAM_INT);
    $data->execute();

    //Clos la connexion
    $dbCon =$db->close();
  return $data->fetchAll(PDO::FETCH_ASSOC);
}

function get_message_topic($forum_id){
      // Instancie d'une nouvelle connexion
    $db =new Db();
    // J'établie la connexion.
    $dbCon =$db->get();

    $sql="SELECT * from forum_message where forum_id=:forum_id";
    $data=$dbCon->prepare($sql);
    $data->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);
    $data->execute();

    //Clos la connexion
    $dbCon =$db->close();
  return $data->fetchAll(PDO::FETCH_ASSOC);
}

function delete_message_by_topic($forum_id)
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="DELETE FROM forum_message WHERE forum_id =:forum_id";
  $stmt=$dbCon->prepare($sql);
  $stmt->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_OBJ);
}

function add_messages($data_2)
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();
    
  $data=$data_2[0]; 

  $sql="INSERT INTO `forum_message`
      (`message_contenu`,`message_createur`,`message_avatar`,`message_time`,`topic_id`,`forum_id`,`message_createur_id`) 
      values
      (?,?,?,?,?,?)";
  $stmt=$dbCon->prepare($sql);
  return $stmt->execute(array($data['message_contenu'], $data['message_createur'],  $data['message_avatar'], $data['message_time'],$data['topic_id'],$data['forum_id'], $data['message_createur_id']));
}

function xml_messages()
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="SELECT * from forum_message";
  $data=$dbCon->query($sql);
  $xml= new XMLWriter();
  $xml->openUri("toutlesmessages.xml");
  $xml->setIndent(true);
  $xml->startDocument('1.0', 'utf-8');
  $xml->startElement('message');

  while($messages=$data->fetch()){
    $xml->startElement('message');
    $xml->writeAttribute('message_id', $messages['message_id']);
    $xml->writeElement('message_contenu',$messages['message_contenu']);
    $xml->writeElement('message_createur',$messages['message_createur']);
    $xml->writeElement('message_avatar',$messages['message_avatar']);
    $xml->writeElement('message_time',$messages['message_time']);
    $xml->writeElement('topic_id',$messages['topic_id']);
    $xml->writeElement('forum_id',$messages['forum_id']);
    $xml->writeElement('message_createur_id',$messages['message_createur_id']);
    $xml->endElement();
  }
  $xml->endElement();
  $xml->endElement();
  $xml->flush();
}

function xml_message_by_id($forum_id, $topic_id){
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();
  $sql="SELECT * from forum_message WHERE forum_id = ".$forum_id." AND topic_id = ".$topic_id."";
  $data=$dbCon->query($sql);
  $xml= new XMLWriter();
  $xml->openUri("messages".$forum_id."_".$topic_id.".xml");
  $xml->setIndent(true);
  $xml->startDocument('1.0', 'utf-8');
  $xml->startElement('message');

    while($messages=$data->fetch()){
      $xml->startElement('message');
      $xml->writeAttribute('message_id', $messages['message_id']);
      $xml->writeElement('message_contenu',$messages['message_contenu']);
      $xml->writeElement('message_createur',$messages['message_createur']);
      $xml->writeElement('message_avatar',$messages['message_avatar']);
      $xml->writeElement('message_time',$messages['message_time']);
      $xml->writeElement('topic_id',$messages['topic_id']);
      $xml->writeElement('forum_id',$messages['forum_id']);
      $xml->writeElement('message_createur_id',$messages['message_createur_id']);
      $xml->endElement();
    }
  $xml->endElement();
  $xml->endElement();
  $xml->flush();
}

function xml_relecture_messages()
{
  $messages = simplexml_load_file('toutlesmessages.xml');
  foreach ($messages->message as $message) {
    echo "Contenu du message :". utf8_decode($message->message_contenu)."<br/>\n";
    echo "Créateur du message :". utf8_decode($message->message_createur)."<br/>\n";
    echo "Date du message :". utf8_decode($message->message_time)."<br/>\n";
      foreach($message->attributes() as $a => $b) {
        echo $a, '="', $b, "\"\n";
      }
    echo '</br></br>';
  }
  echo "<a href='/Projet_PHP/www/xml'>Retour</a>";
}