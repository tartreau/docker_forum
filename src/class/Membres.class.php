<?php
	// Classe permettant de gérer un membre dans la bdd
	class Membres{
		
		private $tableName= 'forum_membres';
		private $dbCon;

		//Constructeur pour un nouveau membre
		function __construct($dbCon)
		{
			$this->dbCon =$dbCon;
		}

		// privatisation des variables
		private $membre_pseudo;
		private $membre_mdp;
		private $membre_email;
		private $membre_siteweb;
	 	private $membre_avatar;
	  	private $membre_description;
	 	private $membre_localisation;
	  	private $membre_inscrit;
	  	private $membre_derniere_visite;

		public function membre_id(){
			return $this->membre_id;
		}

		public function membre_pseudo(){
			return $this->membre_pseudo;
		}
		public function membre_mdp(){
			return $this->membre_mdp;
		}
		public function membre_email(){
			return $this->membre_email;
		}
		public function membre_siteweb(){
			return $this->membre_siteweb;
		}
		public function membre_avatar(){
			return $this->membre_avatar;
		}
		public function membre_description(){
			return $this->membre_description;
		}
		public function membre_inscrit(){
			return $this->membre_inscrit;
		}
		public function membre_derniere_visite(){
			return $this->membre_derniere_visite;
		}



		//Setters
		public function set_membre_id($membre_id)
		{
			$this -> membre_id = $membre_id;
		}
		public function set_membre_pseudo($Membre_pseudo)
		{
			$this -> membre_pseudo = $Membre_pseudo;
		}
		public function set_membre_mdp($Membre_mdp)
		{
			$this -> membre_mdp = $Membre_mdp;
		}
		public function set_membre_email($Membre_email)
		{
			$this -> membre_email = $Membre_email;
		}
		public function set_membre_siteweb($Membre_siteweb)
		{
			$this -> membre_siteweb = $Membre_siteweb;
		}
		public function set_membre_avatar($Membre_avatar)
		{
			$this -> membre_avatar = $Membre_avatar;
		}
		public function set_membre_description($Membre_description)
		{
			$this -> membre_description = $Membre_description;
		}
		public function set_membre_inscrit($Membre_inscrit)
		{
			$this -> membre_inscrit = $Membre_inscrit;
		}
		public function set_membre_derniere_visite($Membre_derniere_visite)
		{
			$this -> membre_derniere_visite = $Membre_derniere_visite;
		}


		// Fonction d'ajout
		public function insert($membre_pseudo,$pass,$email,$website,$nomavatar,$description,$localisation,$temps)
		{
		  $sql="INSERT INTO `{$this->tableName}`
		  (`membre_pseudo`,`membre_mdp`,`membre_email`,`membre_siteweb`,`membre_avatar`,`membre_description`,`membre_localisation`,`membre_inscrit`,`membre_derniere_visite`)
		  VALUES
		  (:membre_pseudo,:pass,:email,:website,:nomavatar,:description,:localisation,:temps,:temps2)";

		  //je prépare la requete
		  $query= $this->dbCon->prepare($sql);
		  $query->bindParam(':membre_pseudo',$membre_pseudo,PDO::PARAM_STR);
		  $query->bindParam(':pass',$pass,PDO::PARAM_STR);
		  $query->bindParam(':email',$email,PDO::PARAM_STR);
		  $query->bindParam(':website',$website,PDO::PARAM_STR);
		  $query->bindParam(':nomavatar',$nomavatar,PDO::PARAM_STR);
		  $query->bindParam(':description',$description,PDO::PARAM_STR);
		  $query->bindParam(':localisation',$localisation,PDO::PARAM_STR);
		  $query->bindParam(':temps',$temps,PDO::PARAM_STR);
		  $query->bindParam(':temps2',$temps,PDO::PARAM_STR);
		  //je l'execute
		  return $query->execute();
		}

		// Fonction de suppression
		function delete_membre_by_id($id)
		{
		  $sql="DELETE FROM forum_membres WHERE membre_id=:membre_id";
		  $query= $this->dbCon->prepare($sql);
		  $query->bindParam(':membre_id', $id, PDO::PARAM_INT);
		  return $query->execute();
		}

		// Fonction de suppression
		function delete_membre_by_pseudo($pseudo)
		{
		  $sql="DELETE FROM forum_membres WHERE membre_pseudo=:membre_pseudo";
		  $query= $this->dbCon->prepare($sql);
		  $query->bindParam(':membre_pseudo', $pseudo, PDO::PARAM_INT);
		  return $query->execute();
		}

		public function updateMembre($membre_id,$membre_pseudo,$membre_mdp,$membre_email,$membre_siteweb, $membre_avatar,$membre_description,$membre_localisation,$membre_inscrit,$membre_derniere_visite)
		{
			$sql= "UPDATE `{$this->tableName}`
					SET `membre_id` = :membre_id,
						`membre_pseudo` = :membre_pseudo,
						`membre_mdp` = :membre_mdp,
						`membre_email`= :membre_email,
						`membre_siteweb` = :membre_siteweb,
						`membre_avatar` = :membre_avatar,
						`membre_description` = :membre_description,
						`membre_localisation` = :membre_localisation,
						`membre_inscrit` = :membre_inscrit,
						`membre_derniere_visite` = :membre_derniere_visite
				WHERE `membre_id` = :membre_id";

				$query= $this->dbCon->prepare($sql);
				$query->bindParam(':membre_id',$membre_id,PDO::PARAM_STR);
				$query->bindParam(':membre_pseudo',$membre_pseudo,PDO::PARAM_STR);
				$query->bindParam(':membre_mdp',$membre_mdp,PDO::PARAM_STR);
				$query->bindParam(':membre_email',$membre_email,PDO::PARAM_STR);
				$query->bindParam(':membre_siteweb',$membre_siteweb,PDO::PARAM_STR);
				$query->bindParam(':membre_avatar',$membre_avatar,PDO::PARAM_STR);
				$query->bindParam(':membre_description',$membre_description,PDO::PARAM_STR);
				$query->bindParam(':membre_localisation',$membre_localisation,PDO::PARAM_STR);
				$query->bindParam(':membre_inscrit',$membre_inscrit,PDO::PARAM_STR);
				$query->bindParam(':membre_derniere_visite',$membre_derniere_visite,PDO::PARAM_STR);
			//je l'execute
			return $query->execute();
		}
	}
