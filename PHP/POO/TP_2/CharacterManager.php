<?php

class CharacterManager {

	protected $_db;

	public function __construct($db){

		$this->setDb($db);
	}

	//--------------------------
	//			SETTERS	
	//--------------------------

	public function setDb(PDO $db){
		$this->_db = $db;
	}

	//--------------------------
	//			METHOD CRUD	
	//--------------------------	

	public function create(Character $person){
		// Préparation de la requête d'insertion.
		$dbh = $this->_db->prepare("INSERT INTO game(name) VALUES(:name) ");
		
		// Assignation des valeurs pour le nom, la force, les dégâts, l'expérience et le niveau du personnage.
		$dbh->bindValue(':name', $person->getName(), PDO::PARAM_STR);

		$dbh->execute();

		$person->hydrate([
			'id' => $this->_db->lastInsertId(),
			'damage' => 0
		]);
	}	

	public function read($info){
		// Si le paramètre est un entier, on veut récupérer le personnage avec son identifiant.
		if(is_int($info)){
			// Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
			$dbh = $this->_db->query('SELECT id, name, damages FROM game WHERE id =' . $info);

			return new Character($dbh->fetch(PDO::FETCH_ASSOC));
		
		// Sinon, on veut récupérer le personnage avec son nom.
		} else {
			// Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
			$dbh = $this->_db->prepare('SELECT id, name, damages FROM game WHERE name = :name');
			$dbh->execute([':name' => $info]);

			return new Character($dbh->fetch(PDO::FETCH_ASSOC));
		}
	}

	public function update(Character $person){
		// Prépare une requête de type UPDATE.
		$dbh = $this->_db->prepare('UPDATE game SET damages = :damages WHERE id = :id');
		
		$dbh->bindValue(':damages', $person->getDamages(), PDO::PARAM_INT);
		$dbh->bindValue(':id', $person->getId(), PDO::PARAM_INT);

		$dbh->execute();

	}

	public function delete(Character $person){
		// Exécute une requête de type DELETE.
		$this->_db->exec('DELETE FROM game WHERE id = ' . $person->getId());
	}

	//--------------------------
	//			METHOD	
	//--------------------------		

	public function readAll($name){
		$persons = [];

		// Retourne la liste des personnages dont le nom n'est pas $nom.
		$dbh = $this->_db->prepare('SELECT id, name, damages FROM game WHERE name <> :name ORDER BY name');
		$dbh->execute([':name' => $name]);

		// Le résultat sera un tableau d'instances de Personnage.
		while($data = $dbh->fetch(PDO::FETCH_ASSOC)){
			$persons[] = new Character($data);
		}

		return $persons;
	}	

	public function exists($info){
		// Si le paramètre est un entier, c'est qu'on a fourni un identifiant.
		// On veut voir si tel personnage ayant pour id $info existe.
		if(is_int($info)){
			// On exécute alors une requête COUNT() avec une clause WHERE, et on retourne un boolean.
			return (bool) $this->_db->query('SELECT COUNT(*) FROM game WHERE id = ' . $info)->fetchColumn();
		}

		// Sinon c'est qu'on a passé un nom et qu'on veut vérifier s'il existe ou pas.
		// Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
		$dbh = $this->_db->prepare('SELECT COUNT(*) FROM game WHERE name = :name');
		$dbh->execute([':name' => $info]);

		return (bool) $dbh->fetchColumn();
	}

	public function count(){
		$dbh = $this->_db->query('SELECT COUNT(*) FROM game');
		
		return $dbh->fetch()[0];

	}
}