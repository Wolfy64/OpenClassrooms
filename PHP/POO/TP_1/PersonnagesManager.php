<?php

class PersonnagesManager{

	private $_db; // Instance PDO

	public function __construct($db){
		$this->setDb($db);
	}

	public function add(Personnage $perso){
		// Préparation de la requête d'insertion.
		$dbh = $this->_db->prepare('INSERT INTO personnages(name) 
									VALUES(:name)' );
		$dbh->bindValue(':name', $perso->getName());
		$dbh->execute();
		
		// Assignation des valeurs pour le nom du personnage.
		$perso->hydrate([
			'id' => $this->_db->lastInsertId(),
			'degats' => 0
		]);
		// Exécution de la requête.
		
		// Hydratation du personnage passé en paramètre avec assignation de son identifiant et des dégâts initiaux (= 0).
	}

	public function count(){
		// Exécute une requête COUNT() et retourne le nombre de résultats retourné.
		return $this->_db->query( 'SELECT COUNT(*)
								   FROM personnages')->fetchcolumn();
	}

	public function delete(Personnage $perso){
		// Exécute une requête de type DELETE.
		$this->_db->exec('DELETE FROM personnages
						WHERE id = '. $perso->getId());
	}

	public function exists($info){
		// Si le paramètre est un entier, c'est qu'on a fourni un identifiant.
		if ( is_int($info)){ // On veut voir si tel personnage ayant pour id $info existe
			// On exécute alors une requête COUNT() avec une clause WHERE, et on retourne un boolean.
			return (bool) $this->_db->query('SELECT COUNT(*)
											 FROM personnages
											 WHERE id =' . $info)->fetchColumn();
		}
		// Sinon c'est qu'on a passé un nom.
		// Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
		$dbh = $this->_db->prepare('SELECT COUNT(*)
									FROM personnages
									WHERE name = :name');
		$dbh->execute([':name'=> $info]);
		
		// Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
		return (bool) $dbh->fetchColumn();
	}

	public function get($info){
		// Si le paramètre est un entier, on veut récupérer le personnage avec son identifiant.
		if( is_int($info) ){
			// Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
			$dbh = $this->_db->query('SELECT id, name, degats
										FROM personnages
										WHERE id =' . $info);
			$data = $dbh->fetch(PDO::FETCH_ASSOC);

			return new Personnage($data);
		} else {
			// Sinon, on veut récupérer le personnage avec son nom.
			// Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
			$dbh = $this->_db->prepare('SELECT id, name, degats
										FROM personnages
										WHERE name = :name');
			$dbh->execute([':name' => $info]);

			return new Personnage($dbh->fetch(PDO::FETCH_ASSOC));
		}

	}

	public function getList($name){
		// Retourne la liste des personnages dont le nom n'est pas $nom.
		// Le résultat sera un tableau d'instances de Personnage.
		$perso = [];

		$dbh = $this->_db->prepare('SELECT id, name, degats
								    FROM personnages
								    WHERE name <> :name
								    ORDER BY name');
		$dbh->execute([':name' => $name]);

		while ($data = $dbh->fetch(PDO::FETCH_ASSOC)) {
			$perso[] = new Personnage($data);
		}

		return $perso;
	}

	public function update(Personnage $perso){
		// Prépare une requête de type UPDATE.
		$dbh = $this->_db->prepare('UPDATE personnages 
									SET degats = :degats
									WHERE id = :id');
		// Assignation des valeurs à la requête.

		$dbh->bindValue(':degats', $perso->getDegats(), PDO::PARAM_INT);
		$dbh->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
		
		// Exécution de la requête.
		$dbh->execute();
	}

	public function setDb(PDO $db){
		$this->_db = $db;
	}

}
