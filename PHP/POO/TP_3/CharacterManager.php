<?php

class CharacterManager {

	protected $db;

	public function __construct($db){

		$this->setDb($db);
	}

	//--------------------------
	//			SETTERS	
	//--------------------------

	public function setDb(PDO $db){
		$this->db = $db;
	}

	//--------------------------
	//			METHOD CRUD	
	//--------------------------	
	
	public function create(Character $person){
		// Préparation de la requête d'insertion.
		$dbh = $this->db->prepare("INSERT INTO game(name, type) VALUES(:name, :type) ");
		
		// Assignation des valeurs pour le nom, la force, les dégâts, l'expérience et le niveau du personnage.
		$dbh->bindValue(':name', $person->getName(), PDO::PARAM_STR);
		$dbh->bindValue(':type', $person->getType(), PDO::PARAM_STR);

		$dbh->execute();

		$person->hydrate([
			'id' => $this->db->lastInsertId(),
			'damages' => 0
		]);
	}	

	public function read($info){

		// Si le paramètre est un entier, on veut récupérer le personnage avec son identifiant.
		if(is_int($info)){
			// Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
			$dbh = $this->db->prepare('SELECT id, name, damages, sleepTime, type FROM game WHERE id = :id');
			$dbh->execute([':id' => $info]);
			
		// Sinon, on veut récupérer le personnage avec son nom.
		} else {
			// Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
			$dbh = $this->db->prepare('SELECT id, name, damages, sleepTime, type FROM game WHERE name = :name');
			$dbh->execute([':name' => $info]);
			
		}

		$donnees = $dbh->fetch(PDO::FETCH_ASSOC);
		$type = $donnees['type'];

		switch ($type){
			case 'warrior':
			return new Warrior($donnees);
			break;

			case 'wizard':
			return new Wizard($donnees);
			break;

			default:
			throw new Exception('Cette classe n\'existe pas !', 1);
			break;
		}
	}

	public function update(Character $person){
		// Prépare une requête de type UPDATE.
		$dbh = $this->db->prepare('UPDATE game SET damages = :damages, sleepTime = :sleepTime WHERE id = :id');
		
		$dbh->bindValue(':damages', $person->getDamages(), PDO::PARAM_INT);
		$dbh->bindValue(':sleepTime', $person->getSleepTime(), PDO::PARAM_INT);
		$dbh->bindValue(':id', $person->getId(), PDO::PARAM_INT);

		$dbh->execute();

	}

	public function delete(Character $person){
		// Exécute une requête de type DELETE.
		$this->db->exec('DELETE FROM game WHERE id = ' . $person->getId());
	}

	//--------------------------
	//			METHOD	
	//--------------------------		

	public function readAll($name){
		$persons = [];

		// Retourne la liste des personnages dont le nom n'est pas $nom.
		$dbh = $this->db->prepare('SELECT id, name, damages, type, sleepTime FROM game WHERE name <> :name ORDER BY name');
		$dbh->execute([':name' => $name]);

		while($data = $dbh->fetch(PDO::FETCH_ASSOC)){
			$persons[] = new warrior($data);
		}

		while($data = $dbh->fetch(PDO::FETCH_ASSOC)){
			$persons[] = new wizard($data);
		}
	
		return $persons;
	}

	public function exists($info){
		// Si le paramètre est un entier, c'est qu'on a fourni un identifiant.
		// On veut voir si tel personnage ayant pour id $info existe.
		if(is_int($info)){
			// On exécute alors une requête COUNT() avec une clause WHERE, et on retourne un boolean.
			return (bool) $this->db->query('SELECT COUNT(*) FROM game WHERE id = ' . $info)->fetchColumn();
		}

		// Sinon c'est qu'on a passé un nom et qu'on veut vérifier s'il existe ou pas.
		// Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
		$dbh = $this->db->prepare('SELECT COUNT(*) FROM game WHERE name = :name');
		$dbh->execute([':name' => $info]);

		return (bool) $dbh->fetchColumn();
	}

	public function count(){
		$dbh = $this->db->query('SELECT COUNT(*) FROM game');
		
		return $dbh->fetch()[0];

	}
	
	public function getType($id){
		$dbh = $this->db->query('SELECT type FROM game WHERE id =' . $id);
		return $dbh->fetch()['type'];
	}

	public function getTypeByName($name){
		$dbh = $this->db->prepare('SELECT type FROM game WHERE name = :name');
		$dbh->execute([':name' => $name]);

		return $dbh->fetch()['type'];

	}

}