<?php

class Character{

	protected $_id,
			  $_name,
			  $_damages,
			  $_sleepTime,
			  $_type,
			  $_asset;

	const ITS_ME = 'hey ! It s me';
	const CHARACTER_HIT = 'The character has been hit!';
	const CHARACTER_KILL = 'The character has been kill!';

	public function  __construct(array $data){
		
		$this->hydrate($data);
	}

	public function hydrate(array $data){
		foreach ( $data as $key => $value ){
			$method = 'set' . ucfirst($key);
	
			if ( method_exists($this, $method) ){
				 $this->$method($value);
			}
		}
	}

	//--------------------------
	//			SETTERS	
	//--------------------------

	public function setId($id){
		
		(int)$id;
		if($id > 0){
			$this->_id = $id;
		}
	}

	public function setName($name){
		
		if(is_string($name)){
			$this->_name = $name;
		}

	}

	public function setDamages($damages){

		$damages = (int)$damages;
		if($damages >= 0 && $damages <= 100){
			$this->_damages = $damages;
		}
	}

	public function setSleepTime(){
		
	}

	public function setType(){

	}

	public function setAsset(){

	}

	//--------------------------
	//			GETTERS	
	//--------------------------

	public function getId(){

		return $this->_id;
	
	}

	public function getName(){

		return $this->_name;

	}

	public function getDamages(){

		return $this->_damages;

	}

	public function getSleepTime(){

		return $this->_sleepTime;
		
	}

	public function getType(){

		return $this->_type;

	}

	public function getAsset(){

		return $this->_asset;

	}

	//--------------------------
	//			METHOD	
	//--------------------------

	public function hit(Character $person){
		// Avant tout : vérifier qu'on ne se frappe pas soi-même.
		if($person->getId() == $this->_id){
			// Si c'est le cas, on stoppe tout en renvoyant une valeur signifiant que le personnage ciblé est le personnage qui attaque.
			return self::ITS_ME;
		}else{
			// On indique au personnage frappé qu'il doit recevoir des dégâts.
			return $person->getHit();
		}
	}

	public function getHit(){
		// On augmente de 5 les dégâts.
		$this->_damages += 5;
		// Si on a 100 de dégâts ou plus, la méthode renverra une valeur signifiant que le personnage a été tué.
		if($this->_damages >= 100){
			return self::CHARACTER_KILL;
		// Sinon, elle renverra une valeur signifiant que le personnage a bien été frappé.
		}else{
			return self::CHARACTER_HIT;
		}
	}

	public function nameAvaible(){
		return !empty($this->_name);
	}

}
