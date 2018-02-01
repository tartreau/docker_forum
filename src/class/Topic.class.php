<?php
// Classe permettant de gérer un topic dans la bdd
class Topic{
	private $tableName= 'forum_topic';
	private $dbCon;
	//Constructeur pour un nouveau topic
	function __construct($dbCon)
	{
		$this->dbCon =$dbCon;
	}

	//Methode d'insertion de nouveau topic
	function insert($forum_id,$topic_titre,$topic_createur,$topic_vu,$topic_time,$topic_genre,$topic_last_post,$topic_first_post,$topic_post,$topic_createur_id)
	{
		$sql="INSERT INTO `{$this->tableName}`
		(`forum_id`,`topic_titre`,`topic_createur`,`topic_vu`,`topic_time`,`topic_genre`,`topic_last_post`,`topic_first_post`,`topic_post`,`topic_createur_id`)
		VALUES
		(:forum_id,:topic_titre,:topic_createur,:topic_vu,:topic_time,:topic_genre,:topic_last_post,:topic_first_post,:topic_post,:topic_createur_id)";

		//je prépare la requete
		$query= $this->dbCon->prepare($sql);
		$query->bindParam(':forum_id',$forum_id,PDO::PARAM_INT);
		$query->bindParam(':topic_titre',$topic_titre,PDO::PARAM_STR);
		$query->bindParam(':topic_createur',$topic_createur,PDO::PARAM_STR);
		$query->bindParam(':topic_vu',$topic_vu,PDO::PARAM_INT);
		$query->bindParam(':topic_time',$topic_time,PDO::PARAM_STR);
		$query->bindParam(':topic_genre',$topic_genre,PDO::PARAM_STR);
		$query->bindParam(':topic_last_post',$topic_last_post,PDO::PARAM_INT);
		$query->bindParam(':topic_first_post',$topic_first_post,PDO::PARAM_INT);
		$query->bindParam(':topic_post',$topic_post,PDO::PARAM_INT);
		$query->bindParam(':topic_createur_id',$_SESSION['id'],PDO::PARAM_STR);
		//je l'execute
		$query->execute();

		/*
		// En cas d'erreur
		print_r($query->errorInfo());
		*/
		
		// L'insertion s'effectue l'identifiant suivant la dernière ligne insérée
    	return $this->dbCon->lastInsertId();
	}
	//Méthode de suppression de topic
	function delete($topic_id)
	{
		$sql="DELETE FROM `{$this->tableName}` WHERE `topic_id`=:topic_id";
		$query= $this->dbCon->prepare($sql);
		$query->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
		/*
		// En cas d'erreur
		print_r($query->errorInfo());
		*/
		return 	$query->execute();
    }
}
