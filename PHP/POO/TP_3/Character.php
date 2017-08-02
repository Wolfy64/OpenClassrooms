<?php

abstract class Character{

	protected $id,
			  $name,
			  $damages,
			  $sleepTime,
			  $type;

	const ITS_ME = 1;
	const CHARACTER_HIT = 2;
	const CHARACTER_KILL = 3;
	const CHARACTER_WITCHED = 4;
	const ITS_ME_SPELL = 5;
	const NO_SPELL = 6;

	public function  __construct(array $data){
		
		$this->hydrate($data);
	}

	public function hydrate(array $data){
		foreach ( $data as $key => $value ){
			$method = 'set' . ucfirst($key);
	
			if ( method_exists($this, $method) ){
				 $this->$method($value);
			} else{
				throw new Exception("manque methode: " . $method, 1);
			}
		}
	}

	//--------------------------
	//			SETTERS
	//--------------------------

	public function setId($id){
		
		(int)$id;
		if($id > 0){
			$this->id = $id;
		}
	}

	public function setName($name){
		
		if(is_string($name)){
			$this->name = $name;
		}

	}

	public function setDamages($damages){

		$damages = (int)$damages;
		if($damages >= 0 && $damages <= 100){
			$this->damages = $damages;
		}
	}

	public function setType($type){
		
		if(is_string($type)){
			$this->type = $type;
		}	
	}

	public function setSleepTime($sleep){
		$this->sleepTime = intval($sleep);
	}

	//--------------------------
	//			GETTERS
	//--------------------------

	public function getId(){

		return $this->id;
	
	}

	public function getName(){

		return $this->name;

	}

	public function getDamages(){

		return $this->damages;

	}

	public function getSleepTime(){

		return $this->sleepTime;
		
	}

	public function getType(){

		return $this->type;

		// switch ($type){
		// 	case 'warrior':
		// 		return 'Guerrier';
		// 		break;
		// 	case 'wizard':
		// 		return 'Mage';
		// 		break;
		// 	default:
		// 		throw new Exception('Cette classe n\'existe pas !', 1);
		// 		break;
		// }
		

	}

	public function getTypeFr(){

		switch ($this->type){
			case 'warrior':
				return 'Guerrier';
				break;
			case 'wizard':
				return 'Mage';
				break;
			default:
				throw new Exception('Cette classe n\'existe pas !', 1);
				break;
		}
	}

	public function getAsset(){
		$damages = $this->damages;

		if ($damages >= 0 && $damages < 25){
			return 4;
		} elseif ($damages >= 25 && $damages < 50){
			return 3;
		}elseif ($damages >= 50 && $damages < 75){
			return 2;
		} elseif ($damages >= 75 && $damages < 90){
			return 1;
		}else{
			return 0;
		}
	}

	public function getAssetClasse(){

		switch ($this->type){
		case 'warrior':
			return 'Protection';
			break;
		case 'wizard':
			return 'Magie';
			break;
		default:
			throw new Exception('Cette classe n\'existe pas !', 1);
			break;
		}
	}

	//--------------------------
	//			METHOD
	//--------------------------

	public function hit(Character $person){
		// Avant tout : vérifier qu'on ne se frappe pas soi-même.
		if($person->getId() == $this->id){
			// Si c'est le cas, on stoppe tout en renvoyant une valeur signifiant que le personnage ciblé est le personnage qui attaque.
			return self::ITS_ME;
		}else{
			// On indique au personnage frappé qu'il doit recevoir des dégâts.
			return $person->getHit();
		}
	}

	public function getHit(){
		// On augmente de 5 les dégâts.
		$this->damages += 5;
		// Si on a 100 de dégâts ou plus, la méthode renverra une valeur signifiant que le personnage a été tué.
		if($this->damages >= 100){
			return self::CHARACTER_KILL;
		// Sinon, elle renverra une valeur signifiant que le personnage a bien été frappé.
		}else{
			return self::CHARACTER_HIT;
		}
	}

	public function nameAvaible(){
		return !empty($this->name);
	}

	public function getSleepCountdown(){

		$sleep = $this->getSleepTime();

		if ($sleep >= time()){

			$remaining = $sleep - time();
			$hours_remaining = floor($remaining / 3600);
			$minutes_remaining = floor($remaining % 3600 / 60);
			$secondes_remaining = floor($remaining % 60);

			echo 'Un magicien vous a endormi ! Vous allez vous réveiller dans ' . $hours_remaining . ' heures ' . $minutes_remaining . ' minutes ' . $secondes_remaining . ' secondes <br>';

			exit();
		} 
	}

	public function getBackground(){

		switch ($this->type) {
			case 'warrior':
				echo 'style="background-color:#FFDADA"';
				break;

			case 'wizard':
				echo 'style="background-color:#DFFAFF"';
				break;
			
			default:
				echo 'style="background-color:white"';
				break;
		}
	}

}
