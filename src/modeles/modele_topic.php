<?php

function get_all_topics(){
	 // Instancie d'une nouvelle connexion
	 $db =new Db();
	 // J'établie la connexion.
	 $dbCon =$db->get();

    $sql="SELECT * from forum_topic";
    if(!$dbCon->query($sql))
	    echo "Pb d'accès à la base";
    else{
      $topic=Array();
      foreach ($dbCon->query($sql) as $row)
        $topic[]=$row;
    }

    //Clos la connexion
    $dbCon =$db->close();
  return $topic;
}

function get_all_topics_links(){
    // Instancie d'une nouvelle connexion
    $db =new Db();
    // J'établie la connexion.
    $dbCon =$db->get();

    $topics = Array();

    $sql="SELECT * from forum_topic";
    $stmt=$dbCon->query($sql);

    while($data=$stmt->fetch(PDO::FETCH_ASSOC)){
        $res=Array();
        $res['topic_titre'] = $data['topic_titre'];
        $res['topic_createur'] = $data['topic_createur'];
        $res['topic_time'] = $data['topic_time'];
        $res['URL']=$_SERVER["REQUEST_SCHEME"].'://'.
        $_SERVER['HTTP_HOST'].
        $_SERVER['CONTEXT_PREFIX'].
        '/www/api/topics/'.$data['topic_titre'];
    $topics[]=$res;
  }
    //Clos la connexion
    $dbCon =$db->close();
  return $topics;
}

function get_topic_id($forum_id){
    // Instancie d'une nouvelle connexion
    $db =new Db();
    // J'établie la connexion.
    $dbCon =$db->get();

    $sql="SELECT * from forum_topic where forum_id=:forum_id";
    $data=$dbCon->prepare($sql);
    $data->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);
    $data->execute();

    //Clos la connexion
    $dbCon =$db->close();
  return $data->fetchAll(PDO::FETCH_ASSOC);
}

function get_topic_id_by_nom($topic_titre){
    // Instancie d'une nouvelle connexion
    $db =new Db();
    // J'établie la connexion.
    $dbCon =$db->get();

    $sql="SELECT * from forum_topic where topic_titre=:topic_titre";
    $data=$dbCon->prepare($sql);
    $data->bindParam(':topic_titre', $topic_titre, PDO::PARAM_INT);
    $data->execute();

    //Clos la connexion
    $dbCon =$db->close();
  return $data->fetchAll(PDO::FETCH_ASSOC);
}

function get_topic_nom($forum_id){
    // Instancie d'une nouvelle connexion
    $db =new Db();
    // J'établie la connexion.
    $dbCon =$db->get();

    $sql="SELECT forum_name from forum_forum where forum_id=:forum_id";
    $data=$dbCon->prepare($sql);
    $data->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);
    $data->execute();

    //Clos la connexion
    $dbCon =$db->close();
  return $data->fetchAll(PDO::FETCH_ASSOC);
}

function delete_topic_by_nom($forum_id)
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="DELETE FROM forum_topic WHERE topic_titre =:topic_titre";
  $stmt=$dbCon->prepare($sql);
  $stmt->bindParam(':forum_titre', $forum_titre, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_OBJ);
}

function add_topic($data)
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();
    
  $sql="INSERT INTO `forum_topic`
      (`forum_id`,`topic_titre`,`topic_createur`,`topic_vu`,`topic_time`,`topic_genre`,`topic_last_post`,`topic_first_post`,`topic_post`,`topic_createur_id`) 
      values
      (?,?,?,?,?,?,?,?,?)";
  $stmt=$connexion->prepare($sql);
  return $stmt->execute(array($data['forum_id'], $data['topic_titre'], $data['topic_createur'],$data['topic_vu'],$data['topic_time'], $data['topic_genre'], $data['topic_last_post'],$data['topic_first_post'],$data['topic_post'],$data['topic_createur_id']));
}

function xml_topic()
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="SELECT * from forum_topic";
  $data=$dbCon->query($sql);
  $xml= new XMLWriter();
  $xml->openUri("toutlestopics.xml");
  $xml->setIndent(true);
  $xml->startDocument('1.0', 'utf-8');
  $xml->startElement('topics');

  while($topic=$data->fetch()){
    $xml->startElement('topic');
    $xml->writeAttribute('topic_id', $topic['topic_id']);
    $xml->writeElement('forum_id',$topic['forum_id']);
    $xml->writeElement('topic_titre',$topic['topic_titre']);
    $xml->writeElement('topic_createur',$topic['topic_createur']);
    $xml->writeElement('topic_vu',$topic['topic_vu']);
    $xml->writeElement('topic_time',$topic['topic_time']);
    $xml->writeElement('topic_genre',$topic['topic_genre']);
    $xml->writeElement('topic_last_post',$topic['topic_last_post']);
    $xml->writeElement('topic_first_post',$topic['topic_first_post']);
    $xml->writeElement('topic_post',$topic['topic_post']);
    $xml->writeElement('topic_createur_id',$topic['topic_createur_id']);
    $xml->endElement();
  }
  $xml->endElement();
  $xml->endElement();
  $xml->flush();
}

function xml_topic_by_id($numero)
{
  $db =new Db();
  // J'établie la connexion.
  $dbCon =$db->get();

  $sql="SELECT * from forum_topic WHERE forum_id=".$numero. "";
  $data=$dbCon->query($sql);
  $xml= new XMLWriter();
  $xml->openUri("topics".$numero.".xml");
  $xml->setIndent(true);
  $xml->startDocument('1.0', 'utf-8');
  $xml->startElement('topics');

  while($topic=$data->fetch()){
    $xml->startElement('topic');
    $xml->writeAttribute('topic_id', $topic['topic_id']);
    $xml->writeElement('forum_id',$topic['forum_id']);
    $xml->writeElement('topic_titre',$topic['topic_titre']);
    $xml->writeElement('topic_createur',$topic['topic_createur']);
    $xml->writeElement('topic_vu',$topic['topic_vu']);
    $xml->writeElement('topic_time',$topic['topic_time']);
    $xml->writeElement('topic_genre',$topic['topic_genre']);
    $xml->writeElement('topic_last_post',$topic['topic_last_post']);
    $xml->writeElement('topic_first_post',$topic['topic_first_post']);
    $xml->writeElement('topic_post',$topic['topic_post']);
    $xml->writeElement('topic_createur_id',$topic['topic_createur_id']);
    $xml->endElement();
  }
  $xml->endElement();
  $xml->endElement();
  $xml->flush();
}

function xml_relecture_topic()
{
  $topics = simplexml_load_file('toutlestopics.xml');
  foreach ($topics->topic as $topic) {
    echo "Titre du topic :". utf8_decode($topic->topic_titre)."<br/>\n";
    echo "Créateur du topic :". utf8_decode($topic->topic_createur)."<br/>\n";
    echo "Date du topic :". utf8_decode($topic->topic_time)."<br/>\n";
    echo "Genre du topic :". utf8_decode($topic->topic_genre)."<br/>\n";
      foreach($topic->attributes() as $a => $b) {
        echo $a, '="', $b, "\"\n";
      }
    echo '</br></br>';
  }
  echo "<a href='/www/xml'>Retour</a>";
}