<?php

class Personnage{
	protected $_id,
			  $_name,
			  $_degats,
			  $_experience;

	const CEST_MOI = 1; // Constente renvoyé si l'on se tape sois même
	const PERSONNAGE_TUE = 2; // Constente renvoyé si l'on est tué
	const PERSONNAGE_FRAPPE = 3; // Constente renvoyé si l'on a frappé un perso

	public function __construct(array $data){
		$this->hydrate($data);
	}

	public function frapper(Personnage $perso){
		// On verifie que l'on ne se tape pas sois même
		if ($perso->getId() == $this->_id){
			return self::CEST_MOI;
		}
		// On indique au personnage qu'il doit recevoir des dégâts
		return $perso->recevoirDegats();
	}

	public function hydrate(array $data){
		foreach ( $data as $key => $value ){
			$method = 'set' . ucfirst($key);
			
			if ( method_exists($this, $method) ){
				$this->$method($value);
			}
		}
	}

	public function recevoirDegats(){
		// Recois 5 point de degats d'un autre perso
		$this->_degats += 5;
	
		//  si on a 100 ou plus de degats le perso est tué sinon on renvoie la valeur restante des degats
		if ( $this->_degats >= 100 ){
			return self::PERSONNAGE_TUE;
		}

		// Sinon, on se contente de dire que le personnage a bien été frappé.
		return self::PERSONNAGE_FRAPPE;
	}

	public function nameOk(){
		return !empty($this->_name);
	}
	
	//	Getters

	public function getDegats(){
		return $this->_degats;
	}

	public function getId(){
		return $this->_id;
	}
	
	public function getName(){
		return $this->_name;
	}

	public function getExperience(){
		return $this->_experience;
	}
	
	//	Setters

	public function setDegats($degats){
		$degats = (int)$degats;

		if ( $degats >= 0 && $degats <= 100 ){
			$this->_degats = $degats;
		}
	}

	public function setId($id){
		$id = (int)$id;

		if ( $id > 0 ){
			$this->_id = $id;
		}
	}

	public function setName($name){
		if ( is_string($name) ){
			$this->_name = $name;
		}
	}

	public  function setExperience($addExperience){
		if ((int)$addExperience){
			$this->_experience = $addExperience;
		}
	}
}
