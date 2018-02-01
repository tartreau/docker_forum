<?php
// Classe permettant de gérer un topic dans la bdd
class Messages{
	private $tableName= 'forum_message';
	private $dbCon;
	//Constructeur pour un nouveau topic
	function __construct($dbCon)
	{
		$this->dbCon =$dbCon;
	}
	//Methode d'insertion de nouveau topic
	function insert($message_contenu,$message_createur,$message_avatar,$message_time,$topic_id,$forum_id,$message_createur_id)
	{
		$sql="INSERT INTO `{$this->tableName}`
		(`message_contenu`,`message_createur`,`message_avatar`,`message_time`,`topic_id`,`forum_id`,`message_createur_id`)
		VALUES
		(:message_contenu,:message_createur,:message_avatar,:message_time,:topic_id,:forum_id,:message_createur_id)";

		//je prépare la requete
		$query= $this->dbCon->prepare($sql);
		$query->bindParam(':message_contenu',$message_contenu,PDO::PARAM_STR);
		$query->bindParam(':message_createur',$message_createur,PDO::PARAM_STR);
		$query->bindParam(':message_avatar',$message_avatar,PDO::PARAM_STR);
		$query->bindParam(':message_time',$message_time,PDO::PARAM_STR);
		$query->bindParam(':topic_id',$topic_id,PDO::PARAM_INT);
		$query->bindParam(':forum_id',$forum_id,PDO::PARAM_INT);
		$query->bindParam(':message_createur_id',$message_createur_id,PDO::PARAM_INT);
		//je l'execute
		$query->execute();

		// L'insertion s'effectue l'identifiant suivant la dernière ligne insérée
    	return $this->dbCon->lastInsertId();
	}
	//Méthode de suppression de topic
	function delete($message_id)
	{
		$sql="DELETE FROM `{$this->tableName}` WHERE `message_id`=:message_id";
		$query= $this->dbCon->prepare($sql);
		$query->bindParam(':message_id', $message_id, PDO::PARAM_INT);

		return 	$query->execute();
    }

    //Méthode update de messages
	function update($message_id, $message_contenu, $message_createur, $message_avatar, $message_time, $topic_id, $forum_id)
	{
		$sql="UPDATE `{$this->tableName}` SET `message_id`=:message_id, `message_contenu`=:message_contenu, `message_createur`=:message_createur, `message_avatar`=:message_avatar,`message_time`=:message_time, `topic_id`=:topic_id, `forum_id`=:forum_id WHERE `message_id`=:message_id";
    	$query=$this->dbCon->prepare($sql);
    	// substition des variables aux marqueurs nommés
    	$query->bindParam(":message_id", $message_id, PDO::PARAM_INT);
   		$query->bindParam(':message_contenu',$message_contenu,PDO::PARAM_STR);
    	$query->bindParam(':message_createur',$message_createur,PDO::PARAM_STR);
    	$query->bindParam(':message_avatar',$message_avatar,PDO::PARAM_STR);
		$query->bindParam(':message_time',$message_time,PDO::PARAM_STR);
		$query->bindParam(':topic_id',$topic_id,PDO::PARAM_INT);
		$query->bindParam(':forum_id',$forum_id,PDO::PARAM_INT);

		/*
		// En cas d'erreur
		print_r($query->errorInfo());
		*/
		return $query->execute();
	}
}
