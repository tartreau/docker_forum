<?php
// Classe regroupant les membres connectés
class Connecte{

	//Attributs
	private $tableName= 'forum_connecte';
	private $dbCon;

	private $membre_pseudo;

	//Constructeur
	function __construct($dbCon)
	{
		$this->dbCon =$dbCon;
	}
	
	//Fonctions
	public function insert($membre_id, $membre_pseudo)
	{
		$sql="INSERT INTO `{$this->tableName}`
		(`membre_id`,`membre_pseudo`)
		VALUES 
		(:membre_id,:membre_pseudo)";

		//requete prepare
		$query= $this->dbCon->prepare($sql);
		$query->bindParam(':membre_id',$membre_id,PDO::PARAM_INT);
		$query->bindParam(':membre_pseudo',$membre_pseudo,PDO::PARAM_STR);

		// En cas d'erreur
		//print_r($query->errorCode());

		return $query->execute();
	}

	public function delete($membre_pseudo)
	{
		$sql="DELETE FROM `{$this->tableName}`WHERE `membre_pseudo`=:membre_pseudo";
		$query= $this->dbCon->prepare($sql);
		$query->bindParam(':membre_pseudo', $membre_pseudo, PDO::PARAM_STR);

		return $query->execute();
    }

    public function delete_by_id($membre_id)
	{
		$sql="DELETE FROM `{$this->tableName}`WHERE `membre_id`=:membre_id";
		$query= $this->dbCon->prepare($sql);
		$query->bindParam(':membre_id', $membre_id, PDO::PARAM_STR);

		return $query->execute();
    }
}